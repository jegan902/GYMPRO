using System;
using System.Collections.Generic;
using GymApi.Entities;

namespace GymApi.Models
{
    // Base DTO with shared common properties - MATCHING FRONTEND EXPECTATIONS
    public class EquipmentBaseDto
    {
        public int Id { get; set; }
        public string DeviceCode { get; set; } = string.Empty;
        public string Name { get; set; } = string.Empty;
        public int? CategoryId { get; set; }
        public string? CategoryName { get; set; }
        public EquipmentStatus Status { get; set; }
        public string StatusName => Status.ToString();
        public string? ImageUrl { get; set; }
        public int BranchId { get; set; }
        public string? BranchName { get; set; }
        public byte[] RowVersion { get; set; } = null!;

        // Added for list view compatibility
        public int Quantity { get; set; }
        public int AvailableQuantity { get; set; }
        public string? Brand { get; set; } // Renamed from BrandName
    }

    public class EquipmentListDto : EquipmentBaseDto
    {
        public string? Model { get; set; }
        public DateTime? NextMaintenanceDate { get; set; }
        public string MaintenancePriority { get; set; } = "Normal";
        public ConditionLevel Condition { get; set; }
        public string ConditionName => Condition.ToString();
        public bool IsWarrantyActive { get; set; }
        
        // Additional flags for UI
        public bool HasFiles { get; set; }
        public bool HasMaintenanceLogs { get; set; }
    }

    // Flat compatibility DTO for Frontend
    public class EquipmentDetailDto : EquipmentListDto
    {
        public string? Description { get; set; }
        public string? QrCode { get; set; }
        public string? Barcode { get; set; }
        
        // Specs
        public decimal? Weight { get; set; }
        public string? WeightUnit { get; set; }
        public decimal? MaxWeight { get; set; }
        public string? Material { get; set; }
        public string? SerialNumber { get; set; }

        // Purchase Info (Current/Latest)
        public DateTime? PurchaseDate { get; set; }
        public decimal? PurchasePrice { get; set; }
        public DateTime? WarrantyExpiry { get; set; }
        public string? InvoiceNumber { get; set; }
        public int? DepreciationYears { get; set; }

        // Supplier
        public string? SupplierName { get; set; }
        public string? SupplierPhone { get; set; }
        public string? SupplierEmail { get; set; }

        // Location (Current)
        public string? Room { get; set; }
        public string? Zone { get; set; }
        public string? Floor { get; set; }
        public string? Position { get; set; }

        // Maintenance
        public int? MaintenanceCycleDays { get; set; }
        public DateTime? LastMaintenanceDate { get; set; }
        public string? MaintenanceVendor { get; set; }
        public string? MaintenanceNote { get; set; }

        // Smart / IoT
        public bool IsSmartDevice { get; set; }
        public string? BleMacAddress { get; set; }
        public string? IpAddress { get; set; }
        public string? FirmwareVersion { get; set; }
        public decimal? UsageHours { get; set; }
        public bool SupportsHeartRate { get; set; }
        public bool SupportsSpo2 { get; set; }
        public bool SupportsAiTracking { get; set; }

        // Collections
        public List<EquipmentMediaDto> Files { get; set; } = new();
        public List<MaintenanceLogDto> MaintenanceLogs { get; set; } = new();
        public List<LocationHistoryDto> LocationHistory { get; set; } = new();
        public List<PurchaseHistoryDto> PurchaseHistory { get; set; } = new();
    }

    // --- Specialized DTOs for Creation/Update ---

    public class CreateEquipmentDto
    {
        public string DeviceCode { get; set; } = string.Empty;
        public string Name { get; set; } = string.Empty;
        public int? CategoryId { get; set; }
        public string? CategoryName { get; set; } // For auto-creation of category dim
        public string? Description { get; set; }
        public int BranchId { get; set; }
        
        // Flattened specs for easier form handling
        public string? BrandName { get; set; }
        public string? SupplierName { get; set; }
        public decimal? PurchasePrice { get; set; }
        public DateTime? PurchaseDate { get; set; }
        public int? MaintenanceCycleDays { get; set; }
        
        public EquipmentStatus Status { get; set; } = EquipmentStatus.Active;
        public ConditionLevel Condition { get; set; } = ConditionLevel.New;
    }

    public class UpdateEquipmentDto
    {
        public string? Name { get; set; }
        public int? CategoryId { get; set; }
        public string? Description { get; set; }
        public EquipmentStatus? Status { get; set; }
        public ConditionLevel? Condition { get; set; }
        
        // Flexible updates for sub-sections
        public decimal? Weight { get; set; }
        public string? Room { get; set; }
        public string? Position { get; set; }
        
        public byte[] RowVersion { get; set; } = null!;
    }

    // --- Sub-Entities DTOs ---

    public class EquipmentMediaDto
    {
        public int Id { get; set; }
        public string MediaType { get; set; } = "Image";
        public string Url { get; set; } = string.Empty;
        public bool IsPrimary { get; set; }
    }

    public class MaintenanceLogDto
    {
        public int Id { get; set; }
        public string Issue { get; set; } = string.Empty;
        public string? RepairAction { get; set; }
        public decimal Cost { get; set; }
        public string? PerformedBy { get; set; }
        public DateTime RepairedAt { get; set; }
        public string Status { get; set; } = "Completed";
        public string? Notes { get; set; }
    }

    public class LocationHistoryDto
    {
        public int Id { get; set; }
        public int BranchId { get; set; }
        public string? BranchName { get; set; }
        public string? Room { get; set; }
        public string? Position { get; set; }
        public DateTime MovedAt { get; set; }
        public string? Notes { get; set; }
    }

    public class PurchaseHistoryDto
    {
        public int Id { get; set; }
        public DateTime PurchaseDate { get; set; }
        public decimal PurchasePrice { get; set; }
        public string? InvoiceNumber { get; set; }
        public int Quantity { get; set; }
    }

    public class EquipmentDashboardDto
    {
        public int TotalEquipments { get; set; }
        public int ActiveEquipments { get; set; }
        public int BrokenEquipments { get; set; }
        public int MaintenanceOverdue { get; set; }
        public decimal TotalAssetValue { get; set; }
        public List<EquipmentListDto> RecentMaintenance { get; set; } = new();
    }

    public class StatusUpdateDto
    {
        public EquipmentStatus Status { get; set; }
    }
}
