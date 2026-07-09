using System;
using System.Collections.Generic;
using System.Linq;
using Microsoft.EntityFrameworkCore;
using GymApi.Entities;

namespace GymApi.Data
{
    public static class DataSeeder
    {
        public static void SeedData(GymDbContext context)
        {
            // Seed Branches
            if (!context.Branches.Any())
            {
                context.Branches.AddRange(
                    new Branch { Name = "HQ Quận 1", Address = "Quận 1, TP.HCM", IsActive = true },
                    new Branch { Name = "Chi nhánh Quận 7", Address = "Quận 7, TP.HCM", IsActive = true }
                );
                context.SaveChanges();
            }

            // Seed Permissions
            if (!context.Permissions.Any())
            {
                context.Permissions.AddRange(
                    new Permission { Name = "view_dashboard", Description = "View Admin Dashboard" },
                    new Permission { Name = "manage_users", Description = "Manage Users and Members" },
                    new Permission { Name = "manage_billing", Description = "Manage Invoices and Payments" },
                    new Permission { Name = "view_ai_reports", Description = "View Medical and AI Reports" }
                );
                context.SaveChanges();
            }

            // Seed Roles
            var superAdminRole = context.Roles.FirstOrDefault(r => r.Name == "Super Admin");
            if (superAdminRole == null)
            {
                superAdminRole = new Role { Name = "Super Admin", Description = "Toàn quyền hệ thống" };
                context.Roles.Add(superAdminRole);
                context.SaveChanges();
                
                var allPermissions = context.Permissions.ToList();
                foreach (var perm in allPermissions)
                {
                    context.RolePermissions.Add(new RolePermission { RoleId = superAdminRole.Id, PermissionId = perm.Id });
                }
                context.SaveChanges();
            }

            var branchAdminRole = context.Roles.FirstOrDefault(r => r.Name == "Branch Admin") ?? new Role { Name = "Branch Admin" };
            var staffRole = context.Roles.FirstOrDefault(r => r.Name == "Staff/PT") ?? new Role { Name = "Staff/PT" };
            var memberRole = context.Roles.FirstOrDefault(r => r.Name == "Member") ?? new Role { Name = "Member" };
            var userRole = context.Roles.FirstOrDefault(r => r.Name == "User") ?? new Role { Name = "User" };

            if (branchAdminRole.Id == 0) context.Roles.Add(branchAdminRole);
            if (staffRole.Id == 0) context.Roles.Add(staffRole);
            if (memberRole.Id == 0) context.Roles.Add(memberRole);
            if (userRole.Id == 0) context.Roles.Add(userRole);
            context.SaveChanges();

            // Seed Admin User
            var hq = context.Branches.First();
            if (!context.Users.Any(u => u.Email == "admin@gympro.com"))
            {
                context.Users.Add(new User
                {
                    FullName = "Super Admin",
                    Email = "admin@gympro.com",
                    Password = BCrypt.Net.BCrypt.HashPassword("admin"),
                    Role = "admin",
                    RoleId = superAdminRole.Id,
                    BranchId = hq.Id,
                    IsActive = true
                });
                context.SaveChanges();
            }

            // Seed Packages
            if (!context.Packages.Any())
            {
                context.Packages.AddRange(
                    new Package
                    {
                        Name = "Gói Standard 30 Ngày",
                        Duration = 30,
                        Price = 350000,
                        Description = "Phù hợp cho người tập tự do cơ bản.",
                        Features = "Tập luyện không giới hạn,Tủ đồ cá nhân,Hỗ trợ nước uống",
                        IsActive = true
                    },
                    new Package
                    {
                        Name = "Gói Pro 90 Ngày",
                        Duration = 90,
                        Price = 900000,
                        Description = "Gói tập phổ biến được nhiều người lựa chọn nhất.",
                        Features = "Tập luyện không giới hạn,Tủ đồ cá nhân,Hỗ trợ nước uống,1 Buổi hướng dẫn cùng PT,Đo BMI/BMR định kỳ",
                        IsActive = true
                    },
                    new Package
                    {
                        Name = "Gói VIP Elite 1 Năm",
                        Duration = 365,
                        Price = 3600000,
                        Description = "Trải nghiệm không giới hạn dịch vụ cao cấp nhất tại GymPro.",
                        Features = "Tập luyện không giới hạn,Tủ đồ cá nhân VIP,Nước uống thể thao miễn phí,10 Buổi PT riêng chuyên sâu,Bể sục & Phòng xông hơi,Đỗ xe ô tô miễn phí",
                        IsActive = true
                    }
                );
                context.SaveChanges();
            }

            SeedEquipmentData(context);
        }

        private static void SeedEquipmentData(GymDbContext context)
        {
            try {
                // [DATABASE-DRIVEN PATCH] Tự động thêm cột nếu chưa có (vì chưa có Migration tool)
                context.Database.ExecuteSqlRaw(@"
                    -- Category Patches
                    IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('equipment_categories_dim') AND name = 'enum_value')
                        ALTER TABLE equipment_categories_dim ADD [enum_value] INT NOT NULL DEFAULT 0;
                    IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('equipment_categories_dim') AND name = 'key')
                        ALTER TABLE equipment_categories_dim ADD [key] NVARCHAR(50) NULL;
                    
                    -- Brand Patches
                    IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('equipment_brands') AND name = 'website')
                        ALTER TABLE equipment_brands ADD [website] NVARCHAR(200) NULL;
                    IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('equipment_brands') AND name = 'country_of_origin')
                        ALTER TABLE equipment_brands ADD [country_of_origin] NVARCHAR(100) NULL;

                    -- Supplier Patches
                    IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('equipment_suppliers') AND name = 'contact_person')
                        ALTER TABLE equipment_suppliers ADD [contact_person] NVARCHAR(200) NULL;
                    IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('equipment_suppliers') AND name = 'address')
                        ALTER TABLE equipment_suppliers ADD [address] NVARCHAR(500) NULL;
                    IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('equipment_suppliers') AND name = 'phone')
                        ALTER TABLE equipment_suppliers ADD [phone] NVARCHAR(50) NULL;
                    IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('equipment_suppliers') AND name = 'email')
                        ALTER TABLE equipment_suppliers ADD [email] NVARCHAR(200) NULL;

                    -- Member Patches (Health & Profile)
                    IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('members') AND name = 'height')
                        ALTER TABLE members ADD [height] DECIMAL(18,2) NULL;
                    IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('members') AND name = 'weight')
                        ALTER TABLE members ADD [weight] DECIMAL(18,2) NULL;
                    IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('members') AND name = 'bmi')
                        ALTER TABLE members ADD [bmi] DECIMAL(18,2) NULL;
                    IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('members') AND name = 'body_fat')
                        ALTER TABLE members ADD [body_fat] DECIMAL(18,2) NULL;
                    IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('members') AND name = 'nationality')
                        ALTER TABLE members ADD [nationality] NVARCHAR(50) NULL;
                    IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('members') AND name = 'id_card')
                        ALTER TABLE members ADD [id_card] NVARCHAR(20) NULL;
                    IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('members') AND name = 'pt_sessions')
                        ALTER TABLE members ADD [pt_sessions] INT NOT NULL DEFAULT 0;

                    -- Create body_metrics table if missing
                    IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID('body_metrics') AND type = 'U')
                    BEGIN
                        CREATE TABLE [body_metrics] (
                            [id] INT IDENTITY(1,1) PRIMARY KEY,
                            [member_id] INT NOT NULL,
                            [weight] DECIMAL(18,2) NULL,
                            [height] DECIMAL(18,2) NULL,
                            [body_fat] DECIMAL(18,2) NULL,
                            [muscle_mass] DECIMAL(18,2) NULL,
                            [bmi] DECIMAL(18,2) NULL,
                            [waist] DECIMAL(18,2) NULL,
                            [chest] DECIMAL(18,2) NULL,
                            [arm] DECIMAL(18,2) NULL,
                            [thigh] DECIMAL(18,2) NULL,
                            [notes] NVARCHAR(MAX) NULL,
                            [measured_date] DATETIME2 NOT NULL,
                            [created_at] DATETIME2 NOT NULL DEFAULT GETDATE()
                        );
                    END

                    -- Create attendance table if missing
                    IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID('attendance') AND type = 'U')
                    BEGIN
                        CREATE TABLE [attendance] (
                            [id] INT IDENTITY(1,1) PRIMARY KEY,
                            [member_id] INT NOT NULL,
                            [check_in_time] DATETIME2 NOT NULL,
                            [check_out_time] DATETIME2 NULL,
                            [method] NVARCHAR(50) NULL DEFAULT 'manual',
                            [created_at] DATETIME2 NOT NULL DEFAULT GETDATE()
                        );
                    END

                    -- Create invoices/payments/subscriptions if missing (basic structure)
                    IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID('subscriptions') AND type = 'U')
                    BEGIN
                        CREATE TABLE [subscriptions] (
                            [id] INT IDENTITY(1,1) PRIMARY KEY,
                            [member_id] INT NOT NULL,
                            [package_id] INT NOT NULL,
                            [start_date] DATETIME2 NULL,
                            [end_date] DATETIME2 NULL,
                            [status] NVARCHAR(20) DEFAULT 'pending',
                            [payment_status] NVARCHAR(20) DEFAULT 'pending',
                            [created_at] DATETIME2 NOT NULL DEFAULT GETDATE(),
                            [updated_at] DATETIME2 NULL,
                            [is_deleted] BIT NOT NULL DEFAULT 0
                        );
                    END

                    IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID('invoices') AND type = 'U')
                    BEGIN
                        CREATE TABLE [invoices] (
                            [id] INT IDENTITY(1,1) PRIMARY KEY,
                            [member_id] INT NOT NULL,
                            [subscription_id] INT NULL,
                            [amount] DECIMAL(18,2) NOT NULL,
                            [status] NVARCHAR(20) DEFAULT 'pending',
                            [notes] NVARCHAR(MAX) NULL,
                            [created_at] DATETIME2 NOT NULL DEFAULT GETDATE(),
                            [updated_at] DATETIME2 NULL,
                            [is_deleted] BIT NOT NULL DEFAULT 0
                        );
                    END

                    IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID('payments') AND type = 'U')
                    BEGIN
                        CREATE TABLE [payments] (
                            [id] INT IDENTITY(1,1) PRIMARY KEY,
                            [invoice_id] INT NOT NULL,
                            [amount] DECIMAL(18,2) NOT NULL,
                            [payment_method] NVARCHAR(50) DEFAULT 'cash',
                            [transaction_id] NVARCHAR(100) NULL,
                            [status] NVARCHAR(20) DEFAULT 'success',
                            [created_at] DATETIME2 NOT NULL DEFAULT GETDATE(),
                            [updated_at] DATETIME2 NULL,
                            [is_deleted] BIT NOT NULL DEFAULT 0
                        );
                    END
                ");

                context.Database.ExecuteSqlRaw("UPDATE equipments SET current_location_id = NULL");
                
                string[] tables = { "maintenance_logs", "equipment_media", "equipment_location_history", 
                                  "equipment_purchase_history", "equipment_smart_configs", "equipment_specifications", 
                                  "equipments", "equipment_brands", "equipment_categories_dim", "equipment_suppliers" };
                
                foreach (var table in tables)
                {
                    context.Database.ExecuteSqlRaw($"DELETE FROM {table}");
                    context.Database.ExecuteSqlRaw($"DBCC CHECKIDENT ('{table}', RESEED, 0)");
                }

                Console.WriteLine("[Seeder] Database cleaned and reset via SQL.");
            } catch (Exception ex) {
                Console.WriteLine("[Seeder] Cleaning error: " + ex.Message);
            }

            // 1. Seed Dimensions
            var brands = new List<EquipmentBrand> {
                new EquipmentBrand { Name = "Technogym", Description = "Premium Italian Equipment" },
                new EquipmentBrand { Name = "Matrix", Description = "Professional Fitness Solutions" },
                new EquipmentBrand { Name = "Life Fitness", Description = "Global Leader in Fitness" },
                new EquipmentBrand { Name = "ZIVA", Description = "High-end Free Weights" },
                new EquipmentBrand { Name = "Precor", Description = "Reliable Cardio Solutions" }
            };
            context.EquipmentBrands.AddRange(brands);

            var categories = new List<EquipmentCategoryDim> {
                new EquipmentCategoryDim { Name = "Máy Tim mạch", Key = "CardioEquipment", EnumValue = EquipmentCategory.CardioEquipment },
                new EquipmentCategoryDim { Name = "Máy tập tạ", Key = "StrengthMachine", EnumValue = EquipmentCategory.StrengthMachine },
                new EquipmentCategoryDim { Name = "Tạ tự do", Key = "FreeWeight", EnumValue = EquipmentCategory.FreeWeight },
                new EquipmentCategoryDim { Name = "Tập chức năng", Key = "FunctionalTraining", EnumValue = EquipmentCategory.FunctionalTraining },
                new EquipmentCategoryDim { Name = "Yoga & Pilates", Key = "YogaEquipment", EnumValue = EquipmentCategory.YogaEquipment },
                new EquipmentCategoryDim { Name = "Thiết bị thông minh", Key = "SmartDeviceIoT", EnumValue = EquipmentCategory.SmartDeviceIoT },
                new EquipmentCategoryDim { Name = "Tủ Locker", Key = "LockerEquipment", EnumValue = EquipmentCategory.LockerEquipment }
            };
            context.EquipmentCategories.AddRange(categories);

            var suppliers = new List<EquipmentSupplier> {
                new EquipmentSupplier { Name = "Technogym VN", Email = "contact@technogym.vn", Phone = "1900-1234" },
                new EquipmentSupplier { Name = "GymX Global", Email = "sales@gymx.com", Phone = "0988-777-666" },
                new EquipmentSupplier { Name = "Hoàng Gia Fitness", Email = "info@hoanggia.vn", Phone = "028-1234-5678" }
            };
            context.EquipmentSuppliers.AddRange(suppliers);
            context.SaveChanges();

            var branches = context.Branches.ToList();
            var branch = branches.First();

            // 2. Seed Main Equipments
            for (int i = 1; i <= 105; i++)
            {
                var brand = brands[i % brands.Count];
                var cat = categories[i % categories.Count];
                var sup = suppliers[i % suppliers.Count];
                var targetBranch = branches[i % branches.Count];
                
                var equipment = new Equipment {
                    DeviceCode = $"EQ-{brand.Name.Substring(0, 2).ToUpper()}-{i:D3}",
                    Name = $"{brand.Name} {cat.Name} Pro Series {i}",
                    Description = $"High performance {cat.Name} equipment from {brand.Name}.",
                    BrandId = brand.Id,
                    CategoryId = cat.Id,
                    SupplierId = sup.Id,
                    BranchId = targetBranch.Id,
                    Status = (i % 20 == 0) ? EquipmentStatus.Broken : ((i % 15 == 0) ? EquipmentStatus.UnderMaintenance : EquipmentStatus.Active),
                    Condition = (i % 30 == 0) ? ConditionLevel.Poor : ConditionLevel.New,
                    ImageUrl = GetMockImageUrl(cat.EnumValue),
                    CreatedAt = DateTime.UtcNow
                };
                context.Equipments.Add(equipment);
                context.SaveChanges();

                // 3. Related 1:1
                context.EquipmentSpecifications.Add(new EquipmentSpecification {
                    EquipmentId = equipment.Id,
                    Weight = 50 + (i * 2),
                    WeightUnit = "kg",
                    Model = $"Mod-{brand.Name}-{2024}",
                    SerialNumber = $"SN-{equipment.DeviceCode}-{i:D4}"
                });

                if (cat.EnumValue == EquipmentCategory.CardioEquipment || cat.EnumValue == EquipmentCategory.SmartDeviceIoT) {
                    context.EquipmentSmartConfigs.Add(new EquipmentSmartConfig {
                        EquipmentId = equipment.Id,
                        IsSmartDevice = true,
                        BleMacAddress = $"AA:BB:CC:{i:X2}:{i:X2}:{i:X2}",
                        IpAddress = $"192.168.{targetBranch.Id}.{100 + i}",
                        FirmwareVersion = "v3.0.1"
                    });
                }

                // 4. History 1:N
                context.EquipmentPurchases.Add(new EquipmentPurchaseHistory {
                    EquipmentId = equipment.Id,
                    PurchaseDate = DateTime.UtcNow.AddMonths(-i % 24),
                    PurchasePrice = 10000000 + (i * 500000),
                    Quantity = 1,
                    InvoiceNumber = $"VAT-{2024}-{i:D4}"
                });

                var loc = new EquipmentLocationHistory {
                    EquipmentId = equipment.Id,
                    BranchId = targetBranch.Id,
                    Room = i % 2 == 0 ? "Main Hall" : "Zone B",
                    MovedAt = DateTime.UtcNow.AddDays(-i),
                    Notes = "Initial placement"
                };
                context.EquipmentLocations.Add(loc);
                context.SaveChanges();

                equipment.CurrentLocationId = loc.Id;
                context.SaveChanges();

                context.EquipmentMediaFiles.Add(new EquipmentMedia {
                    EquipmentId = equipment.Id,
                    Url = equipment.ImageUrl!,
                    IsPrimary = true
                });

                if (equipment.Status == EquipmentStatus.UnderMaintenance || equipment.Status == EquipmentStatus.Broken) {
                    context.MaintenanceLogs.Add(new MaintenanceLog {
                        EquipmentId = equipment.Id,
                        Issue = "Check-up required",
                        RepairAction = "Inspection pending",
                        Cost = 0,
                        PerformedBy = "Pending",
                        RepairedAt = DateTime.UtcNow,
                        Status = "In Progress"
                    });
                }
            }
            context.SaveChanges();
            Console.WriteLine("[Seeder] 105 Normalized & Database-Driven Categorized Equipments seeded.");
        }

        private static string GetMockImageUrl(EquipmentCategory cat)
        {
            return cat switch
            {
                EquipmentCategory.CardioEquipment => "https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?w=200",
                EquipmentCategory.StrengthMachine => "https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=200",
                EquipmentCategory.FreeWeight => "https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=200",
                _ => "https://images.unsplash.com/photo-1540497077202-7c8a3999166f?w=200"
            };
        }
    }
}
