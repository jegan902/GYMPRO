using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using Microsoft.EntityFrameworkCore;

namespace GymApi.Entities
{
    // --- DIMENSION TABLES (Master Data) ---

    [Table("equipment_brands")]
    public class EquipmentBrand : BaseEntity
    {
        [Required, MaxLength(100)]
        public string Name { get; set; } = string.Empty;
        public string? Description { get; set; }
        public string? Website { get; set; }
        
        [Column("country_of_origin")]
        public string? CountryOfOrigin { get; set; }

        public ICollection<Equipment> Equipments { get; set; } = new List<Equipment>();
    }

    [Table("equipment_categories_dim")]
    public class EquipmentCategoryDim : BaseEntity
    {
        [Required, MaxLength(100)]
        public string Name { get; set; } = string.Empty; // Display Name: "Máy Tim mạch"
        
        [Required, MaxLength(50)]
        public string Key { get; set; } = string.Empty; // System Key: "CardioEquipment"

        public string? Description { get; set; }

        [Column("enum_value")]
        public EquipmentCategory EnumValue { get; set; }

        public ICollection<Equipment> Equipments { get; set; } = new List<Equipment>();
    }

    [Table("equipment_suppliers")]
    public class EquipmentSupplier : BaseEntity
    {
        [Required, MaxLength(200)]
        public string Name { get; set; } = string.Empty;

        [Column("contact_person")]
        public string? ContactPerson { get; set; }
        
        public string? Phone { get; set; }
        public string? Email { get; set; }
        public string? Address { get; set; }

        public ICollection<Equipment> Equipments { get; set; } = new List<Equipment>();
    }

    // --- CORE ENTITY ---

    [Table("equipments")]
    [Index(nameof(DeviceCode), IsUnique = true)]
    public class Equipment : BaseEntity
    {
        [Required, MaxLength(50)]
        [Column("device_code")]
        public string DeviceCode { get; set; } = string.Empty;

        [Required, MaxLength(200)]
        public string Name { get; set; } = string.Empty;

        public string? Description { get; set; }
        
        [Column("image_url")]
        public string? ImageUrl { get; set; }

        // Foreign Keys
        [Column("branch_id")]
        public int BranchId { get; set; }
        
        [Column("brand_id")]
        public int? BrandId { get; set; }
        
        [Column("category_id")]
        public int? CategoryId { get; set; }
        
        [Column("supplier_id")]
        public int? SupplierId { get; set; }

        // Current Location Pointer (Optimization)
        [Column("current_location_id")]
        public int? CurrentLocationId { get; set; }

        // Core Status
        public EquipmentStatus Status { get; set; } = EquipmentStatus.Active;
        public ConditionLevel Condition { get; set; } = ConditionLevel.New;

        // Identification
        [Column("qr_code")]
        public string? QrCode { get; set; }
        public string? Barcode { get; set; }

        // Navigation Properties
        [ForeignKey(nameof(BranchId))]
        public Branch? Branch { get; set; }

        [ForeignKey(nameof(BrandId))]
        public EquipmentBrand? Brand { get; set; }

        [ForeignKey(nameof(CategoryId))]
        public EquipmentCategoryDim? Category { get; set; }

        [ForeignKey(nameof(SupplierId))]
        public EquipmentSupplier? Supplier { get; set; }

        [ForeignKey(nameof(CurrentLocationId))]
        public EquipmentLocationHistory? CurrentLocation { get; set; }

        // 1:1 Relations
        public EquipmentSpecification? Specification { get; set; }
        public EquipmentSmartConfig? SmartConfig { get; set; }

        // 1:N Relations
        public ICollection<EquipmentPurchaseHistory> Purchases { get; set; } = new List<EquipmentPurchaseHistory>();
        public ICollection<EquipmentLocationHistory> Locations { get; set; } = new List<EquipmentLocationHistory>();
        public ICollection<MaintenanceLog> MaintenanceLogs { get; set; } = new List<MaintenanceLog>();
        public ICollection<EquipmentMedia> MediaFiles { get; set; } = new List<EquipmentMedia>();

        [Timestamp]
        public byte[] RowVersion { get; set; } = null!;
    }

    // --- CONFIGURATION & SPECIFICATION (1:1) ---

    [Table("equipment_specifications")]
    public class EquipmentSpecification : BaseEntity
    {
        [Column("equipment_id")]
        public int EquipmentId { get; set; }
        public decimal? Weight { get; set; }
        
        [Column("weight_unit")]
        public string? WeightUnit { get; set; } = "kg";
        
        [Column("max_weight")]
        public decimal? MaxWeight { get; set; }
        public string? Material { get; set; }
        public string? Model { get; set; }
        
        [Column("serial_number")]
        public string? SerialNumber { get; set; }
        
        [Column("additional_specs_json")]
        public string? AdditionalSpecsJson { get; set; }

        [ForeignKey(nameof(EquipmentId))]
        public Equipment? Equipment { get; set; }
    }

    [Table("equipment_smart_configs")]
    public class EquipmentSmartConfig : BaseEntity
    {
        [Column("equipment_id")]
        public int EquipmentId { get; set; }
        
        [Column("is_smart_device")]
        public bool IsSmartDevice { get; set; }
        
        [Column("ble_mac_address")]
        public string? BleMacAddress { get; set; }
        
        [Column("ip_address")]
        public string? IpAddress { get; set; }
        
        [Column("firmware_version")]
        public string? FirmwareVersion { get; set; }
        
        [Column("usage_hours")]
        public decimal? UsageHours { get; set; }
        
        [Column("supports_heart_rate")]
        public bool SupportsHeartRate { get; set; }
        
        [Column("supports_spo2")]
        public bool SupportsSpo2 { get; set; }
        
        [Column("supports_ai_tracking")]
        public bool SupportsAiTracking { get; set; }

        [ForeignKey(nameof(EquipmentId))]
        public Equipment? Equipment { get; set; }
    }

    // --- HISTORICAL DATA (1:N) ---

    [Table("equipment_purchase_history")]
    public class EquipmentPurchaseHistory : BaseEntity
    {
        [Column("equipment_id")]
        public int EquipmentId { get; set; }
        
        [Column("purchase_date")]
        public DateTime PurchaseDate { get; set; }
        
        [Column("purchase_price")]
        public decimal PurchasePrice { get; set; }
        
        [Column("warranty_expiry")]
        public DateTime? WarrantyExpiry { get; set; }
        
        [Column("invoice_number")]
        public string? InvoiceNumber { get; set; }
        public int Quantity { get; set; } = 1;
        public string? Notes { get; set; }

        [ForeignKey(nameof(EquipmentId))]
        public Equipment? Equipment { get; set; }
    }

    [Table("equipment_location_history")]
    public class EquipmentLocationHistory : BaseEntity
    {
        [Column("equipment_id")]
        public int EquipmentId { get; set; }
        
        [Column("branch_id")]
        public int BranchId { get; set; }
        public string? Room { get; set; }
        public string? Zone { get; set; }
        public string? Floor { get; set; }
        public string? Position { get; set; }
        
        [Column("moved_at")]
        public DateTime MovedAt { get; set; }
        public string? Notes { get; set; }

        [ForeignKey(nameof(EquipmentId))]
        public Equipment? Equipment { get; set; }

        [ForeignKey(nameof(BranchId))]
        public Branch? Branch { get; set; }
    }

    [Table("maintenance_logs")]
    public class MaintenanceLog : BaseEntity
    {
        [Column("equipment_id")]
        public int EquipmentId { get; set; }
        [Required]
        public string Issue { get; set; } = string.Empty;
        
        [Column("repair_action")]
        public string? RepairAction { get; set; }
        public decimal Cost { get; set; }
        
        [Column("performed_by")]
        public string? PerformedBy { get; set; }
        
        [Column("repaired_at")]
        public DateTime RepairedAt { get; set; }
        public string Status { get; set; } = "Completed"; // Completed, Pending, In Progress
        public string? Notes { get; set; }

        [ForeignKey(nameof(EquipmentId))]
        public Equipment? Equipment { get; set; }
    }

    [Table("equipment_media")]
    public class EquipmentMedia : BaseEntity
    {
        [Column("equipment_id")]
        public int EquipmentId { get; set; }
        [Required]
        public string Url { get; set; } = string.Empty;
        
        [Column("media_type")]
        public string MediaType { get; set; } = "Image"; // Image, Video, Manual
        
        [Column("is_primary")]
        public bool IsPrimary { get; set; } = false;

        [ForeignKey(nameof(EquipmentId))]
        public Equipment? Equipment { get; set; }
    }
}
