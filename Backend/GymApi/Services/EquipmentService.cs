using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.EntityFrameworkCore;
using GymApi.Data;
using GymApi.Entities;
using GymApi.Models;

namespace GymApi.Services
{
    public interface IEquipmentService
    {
        Task<(List<EquipmentListDto> Items, int TotalCount)> GetEquipmentsAsync(int branchId, EquipmentStatus? status, EquipmentCategory? category, string? search, int page = 1, int pageSize = 20);
        Task<EquipmentDetailDto?> GetEquipmentByIdAsync(int id, int branchId);
        Task<EquipmentDetailDto> CreateEquipmentAsync(CreateEquipmentDto dto, string username);
        Task<EquipmentDetailDto> UpdateEquipmentAsync(int id, UpdateEquipmentDto dto, int branchId, string username);
        Task<bool> DeleteEquipmentAsync(int id, int branchId, string username);
        Task<EquipmentDashboardDto> GetDashboardMetricsAsync(int branchId);
        Task<bool> AddMaintenanceLogAsync(int id, MaintenanceLogDto logDto, int branchId, string username);
        Task<EquipmentListDto> ChangeStatusAsync(int id, EquipmentStatus newStatus, string username);
    }

    public class EquipmentService : IEquipmentService
    {
        private readonly GymDbContext _context;

        public EquipmentService(GymDbContext context)
        {
            _context = context;
        }

        public async Task<(List<EquipmentListDto> Items, int TotalCount)> GetEquipmentsAsync(int branchId, EquipmentStatus? status, EquipmentCategory? category, string? search, int page = 1, int pageSize = 20)
        {
            var query = _context.Equipments
                .Include(e => e.Branch)
                .Include(e => e.Brand)
                .Include(e => e.Category)
                .Include(e => e.Purchases)
                .Include(e => e.MaintenanceLogs)
                .Include(e => e.MediaFiles)
                .AsQueryable();

            if (branchId > 0)
                query = query.Where(e => e.BranchId == branchId);

            if (status.HasValue)
                query = query.Where(e => e.Status == status.Value);

            if (category.HasValue)
                query = query.Where(e => e.Category != null && e.Category.EnumValue == category.Value);

            if (!string.IsNullOrEmpty(search))
            {
                search = search.ToLower();
                query = query.Where(e => e.Name.ToLower().Contains(search) || 
                                         e.DeviceCode.ToLower().Contains(search));
            }

            var totalCount = await query.CountAsync();

            var items = await query
                .OrderByDescending(e => e.CreatedAt)
                .Skip((page - 1) * pageSize)
                .Take(pageSize)
                .ToListAsync();

            var dtos = items.Select(MapToSummaryDto).ToList();

            return (dtos, totalCount);
        }

        public async Task<EquipmentDetailDto?> GetEquipmentByIdAsync(int id, int branchId)
        {
            var e = await _context.Equipments
                .Include(e => e.Branch)
                .Include(e => e.Brand)
                .Include(e => e.Category)
                .Include(e => e.Supplier)
                .Include(e => e.Specification)
                .Include(e => e.SmartConfig)
                .Include(e => e.Purchases.OrderByDescending(p => p.PurchaseDate))
                .Include(e => e.Locations.OrderByDescending(l => l.MovedAt))
                .Include(e => e.MaintenanceLogs.OrderByDescending(m => m.RepairedAt))
                .Include(e => e.MediaFiles)
                .FirstOrDefaultAsync(e => e.Id == id && (branchId == 0 || e.BranchId == branchId));

            if (e == null) return null;

            return MapToDetailDto(e);
        }

        public async Task<EquipmentDetailDto> CreateEquipmentAsync(CreateEquipmentDto dto, string username)
        {
            using var transaction = await _context.Database.BeginTransactionAsync();
            try
            {
                var brandId = await ResolveBrandAsync(dto.BrandName);
                var categoryId = await ResolveCategoryAsync(dto.CategoryId, dto.CategoryName);
                var supplierId = await ResolveSupplierAsync(dto.SupplierName);

                var equipment = new Equipment
                {
                    DeviceCode = dto.DeviceCode,
                    Name = dto.Name,
                    Description = dto.Description,
                    BranchId = dto.BranchId,
                    BrandId = brandId,
                    CategoryId = categoryId,
                    SupplierId = supplierId,
                    Status = dto.Status,
                    Condition = dto.Condition,
                    CreatedBy = username,
                    CreatedAt = DateTime.UtcNow
                };

                _context.Equipments.Add(equipment);
                await _context.SaveChangesAsync();

                var purchase = new EquipmentPurchaseHistory
                {
                    EquipmentId = equipment.Id,
                    PurchaseDate = dto.PurchaseDate ?? DateTime.UtcNow,
                    PurchasePrice = dto.PurchasePrice ?? 0,
                    Quantity = 1,
                    CreatedBy = username
                };
                _context.EquipmentPurchases.Add(purchase);

                var location = new EquipmentLocationHistory
                {
                    EquipmentId = equipment.Id,
                    BranchId = dto.BranchId,
                    MovedAt = DateTime.UtcNow,
                    Notes = "Initial placement upon creation",
                    CreatedBy = username
                };
                _context.EquipmentLocations.Add(location);

                await _context.SaveChangesAsync();

                equipment.CurrentLocationId = location.Id;
                await _context.SaveChangesAsync();

                await transaction.CommitAsync();
                
                return await GetEquipmentByIdAsync(equipment.Id, 0) ?? throw new Exception("Failed to load created record");
            }
            catch (Exception)
            {
                await transaction.RollbackAsync();
                throw;
            }
        }

        public async Task<EquipmentDetailDto> UpdateEquipmentAsync(int id, UpdateEquipmentDto dto, int branchId, string username)
        {
            using var transaction = await _context.Database.BeginTransactionAsync();
            try
            {
                var e = await _context.Equipments
                    .Include(e => e.Specification)
                    .FirstOrDefaultAsync(e => e.Id == id && (branchId == 0 || e.BranchId == branchId));

                if (e == null) throw new KeyNotFoundException("Equipment not found");
                if (!e.RowVersion.SequenceEqual(dto.RowVersion))
                    throw new DbUpdateConcurrencyException("Record modified by another user.");

                if (dto.Name != null) e.Name = dto.Name;
                if (dto.CategoryId.HasValue) e.CategoryId = dto.CategoryId;
                if (dto.Description != null) e.Description = dto.Description;
                if (dto.Status.HasValue) e.Status = dto.Status.Value;
                if (dto.Condition.HasValue) e.Condition = dto.Condition.Value;
                
                e.UpdatedBy = username;
                e.UpdatedAt = DateTime.UtcNow;

                if (dto.Weight.HasValue)
                {
                    if (e.Specification == null) 
                        e.Specification = new EquipmentSpecification { EquipmentId = id, CreatedBy = username };
                    e.Specification.Weight = dto.Weight;
                }

                await _context.SaveChangesAsync();
                await transaction.CommitAsync();

                return await GetEquipmentByIdAsync(id, 0) ?? throw new Exception("Failed to reload record");
            }
            catch (Exception)
            {
                await transaction.RollbackAsync();
                throw;
            }
        }

        public async Task<bool> DeleteEquipmentAsync(int id, int branchId, string username)
        {
            var e = await _context.Equipments.FirstOrDefaultAsync(e => e.Id == id && (branchId == 0 || e.BranchId == branchId));
            if (e == null) return false;

            e.IsDeleted = true;
            e.DeletedAt = DateTime.UtcNow;
            e.UpdatedBy = username;

            await _context.SaveChangesAsync();
            return true;
        }

        public async Task<EquipmentDashboardDto> GetDashboardMetricsAsync(int branchId)
        {
            var query = _context.Equipments.Include(e => e.Purchases).AsQueryable();
            if (branchId > 0) query = query.Where(e => e.BranchId == branchId);

            var list = await query.ToListAsync();
            return new EquipmentDashboardDto
            {
                TotalEquipments = list.Sum(e => e.Purchases.Sum(p => p.Quantity)),
                ActiveEquipments = list.Where(e => e.Status == EquipmentStatus.Active).Sum(e => e.Purchases.Sum(p => p.Quantity)),
                BrokenEquipments = list.Where(e => e.Status == EquipmentStatus.Broken).Sum(e => e.Purchases.Sum(p => p.Quantity)),
                TotalAssetValue = list.Sum(e => e.Purchases.Sum(p => p.PurchasePrice))
            };
        }

        public async Task<bool> AddMaintenanceLogAsync(int id, MaintenanceLogDto logDto, int branchId, string username)
        {
            var equipment = await _context.Equipments.FirstOrDefaultAsync(e => e.Id == id && (branchId == 0 || e.BranchId == branchId));
            if (equipment == null) return false;

            var log = new MaintenanceLog
            {
                EquipmentId = id,
                Issue = logDto.Issue,
                RepairAction = logDto.RepairAction,
                Cost = logDto.Cost,
                PerformedBy = logDto.PerformedBy ?? username,
                RepairedAt = logDto.RepairedAt,
                Status = logDto.Status,
                Notes = logDto.Notes,
                CreatedBy = username
            };

            _context.MaintenanceLogs.Add(log);
            await _context.SaveChangesAsync();
            return true;
        }

        public async Task<EquipmentListDto> ChangeStatusAsync(int id, EquipmentStatus newStatus, string username)
        {
            var e = await _context.Equipments.Include(x => x.Branch).Include(x => x.Brand).Include(x => x.Category).Include(x => x.Purchases).FirstOrDefaultAsync(x => x.Id == id);
            if (e == null) throw new KeyNotFoundException("Not found");

            e.Status = newStatus;
            e.UpdatedBy = username;
            await _context.SaveChangesAsync();

            return MapToSummaryDto(e);
        }

        // --- PRIVATE HELPERS ---

        private async Task<int?> ResolveBrandAsync(string? name)
        {
            if (string.IsNullOrWhiteSpace(name)) return null;
            name = name.Trim();
            var brand = await _context.EquipmentBrands.FirstOrDefaultAsync(b => b.Name.ToLower() == name.ToLower());
            if (brand == null)
            {
                brand = new EquipmentBrand { Name = name, CreatedBy = "System" };
                _context.EquipmentBrands.Add(brand);
                await _context.SaveChangesAsync();
            }
            return brand.Id;
        }

        private async Task<int?> ResolveCategoryAsync(int? id, string? name)
        {
            if (id.HasValue && id > 0) return id;
            if (string.IsNullOrWhiteSpace(name)) return null;
            name = name.Trim();
            var cat = await _context.EquipmentCategories.FirstOrDefaultAsync(c => c.Name.ToLower() == name.ToLower());
            if (cat == null)
            {
                cat = new EquipmentCategoryDim { Name = name, CreatedBy = "System", Key = "Khác", EnumValue = EquipmentCategory.CardioEquipment };
                _context.EquipmentCategories.Add(cat);
                await _context.SaveChangesAsync();
            }
            return cat.Id;
        }

        private async Task<int?> ResolveSupplierAsync(string? name)
        {
            if (string.IsNullOrWhiteSpace(name)) return null;
            name = name.Trim();
            var sup = await _context.EquipmentSuppliers.FirstOrDefaultAsync(s => s.Name.ToLower() == name.ToLower());
            if (sup == null)
            {
                sup = new EquipmentSupplier { Name = name, CreatedBy = "System" };
                _context.EquipmentSuppliers.Add(sup);
                await _context.SaveChangesAsync();
            }
            return sup.Id;
        }

        private EquipmentListDto MapToSummaryDto(Equipment e)
        {
            return new EquipmentListDto
            {
                Id = e.Id,
                DeviceCode = e.DeviceCode,
                Name = e.Name,
                CategoryId = e.CategoryId,
                CategoryName = e.Category != null ? (e.Category.Key ?? "Khác") : "Khác",
                Status = e.Status,
                ImageUrl = e.ImageUrl,
                BranchId = e.BranchId,
                BranchName = e.Branch?.Name,
                Brand = e.Brand?.Name,
                Quantity = e.Purchases.Sum(p => p.Quantity),
                AvailableQuantity = e.Status == EquipmentStatus.Active || e.Status == EquipmentStatus.Idle ? e.Purchases.Sum(p => p.Quantity) : 0,
                Condition = e.Condition,
                HasFiles = e.MediaFiles.Any(),
                HasMaintenanceLogs = e.MaintenanceLogs.Any(),
                RowVersion = e.RowVersion
            };
        }

        private EquipmentDetailDto MapToDetailDto(Equipment e)
        {
            var latestPurchase = e.Purchases.OrderByDescending(p => p.PurchaseDate).FirstOrDefault();
            var latestLoc = e.Locations.OrderByDescending(l => l.MovedAt).FirstOrDefault();
            var latestMaint = e.MaintenanceLogs.OrderByDescending(m => m.RepairedAt).FirstOrDefault();
            var totalQty = e.Purchases.Sum(p => p.Quantity);

            return new EquipmentDetailDto
            {
                Id = e.Id,
                DeviceCode = e.DeviceCode,
                Name = e.Name,
                CategoryId = e.CategoryId,
                CategoryName = e.Category != null ? (e.Category.Key ?? "Khác") : "Khác",
                Status = e.Status,
                ImageUrl = e.ImageUrl,
                BranchId = e.BranchId,
                BranchName = e.Branch?.Name,
                Brand = e.Brand?.Name,
                Quantity = totalQty,
                AvailableQuantity = e.Status == EquipmentStatus.Active || e.Status == EquipmentStatus.Idle ? totalQty : 0,
                RowVersion = e.RowVersion,
                
                Description = e.Description,
                QrCode = e.QrCode,
                Barcode = e.Barcode,

                // Specs
                Weight = e.Specification?.Weight,
                WeightUnit = e.Specification?.WeightUnit,
                MaxWeight = e.Specification?.MaxWeight,
                Material = e.Specification?.Material,
                SerialNumber = e.Specification?.SerialNumber,

                // Purchase
                PurchaseDate = latestPurchase?.PurchaseDate,
                PurchasePrice = latestPurchase?.PurchasePrice,
                WarrantyExpiry = latestPurchase?.WarrantyExpiry,
                InvoiceNumber = latestPurchase?.InvoiceNumber,

                // Supplier
                SupplierName = e.Supplier?.Name,
                SupplierPhone = e.Supplier?.Phone,
                SupplierEmail = e.Supplier?.Email,

                // Location
                Room = latestLoc?.Room,
                Zone = latestLoc?.Zone,
                Floor = latestLoc?.Floor,
                Position = latestLoc?.Position,

                // Maintenance
                LastMaintenanceDate = latestMaint?.RepairedAt,
                MaintenanceVendor = latestMaint?.PerformedBy, 

                // Smart
                IsSmartDevice = e.SmartConfig?.IsSmartDevice ?? false,
                BleMacAddress = e.SmartConfig?.BleMacAddress,
                IpAddress = e.SmartConfig?.IpAddress,
                FirmwareVersion = e.SmartConfig?.FirmwareVersion,
                UsageHours = e.SmartConfig?.UsageHours,
                SupportsHeartRate = e.SmartConfig?.SupportsHeartRate ?? false,
                SupportsSpo2 = e.SmartConfig?.SupportsSpo2 ?? false,
                SupportsAiTracking = e.SmartConfig?.SupportsAiTracking ?? false,

                // Collections
                Files = e.MediaFiles.Select(m => new EquipmentMediaDto { Id = m.Id, MediaType = m.MediaType, Url = m.Url, IsPrimary = m.IsPrimary }).ToList(),
                MaintenanceLogs = e.MaintenanceLogs.Select(m => new MaintenanceLogDto { 
                    Id = m.Id, Issue = m.Issue, RepairAction = m.RepairAction, Cost = m.Cost, PerformedBy = m.PerformedBy, RepairedAt = m.RepairedAt, Status = m.Status, Notes = m.Notes 
                }).ToList(),
                LocationHistory = e.Locations.Select(l => new LocationHistoryDto { Id = l.Id, BranchId = l.BranchId, Room = l.Room, Position = l.Position, MovedAt = l.MovedAt }).ToList(),
                PurchaseHistory = e.Purchases.Select(p => new PurchaseHistoryDto { Id = p.Id, PurchaseDate = p.PurchaseDate, PurchasePrice = p.PurchasePrice, InvoiceNumber = p.InvoiceNumber, Quantity = p.Quantity }).ToList()
            };
        }
    }
}
