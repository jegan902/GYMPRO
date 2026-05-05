using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GymApi.Entities
{
    [Table("packages")]
    public class Package : BaseEntity
    {
        [Required]
        [MaxLength(100)]
        [Column("name")]
        public string Name { get; set; } = string.Empty;

        [Column("duration")]
        public int Duration { get; set; } // in days

        [Column("price")]
        public decimal Price { get; set; }

        [Column("description")]
        public string? Description { get; set; }

        [Column("features")]
        public string? Features { get; set; }

        [Column("is_active")]
        public bool IsActive { get; set; } = true;
    }

    [Table("subscriptions")]
    public class Subscription : BaseEntity
    {
        [Required]
        [Column("member_id")]
        public int MemberId { get; set; }

        [ForeignKey("MemberId")]
        public Member? Member { get; set; }

        [Required]
        [Column("package_id")]
        public int PackageId { get; set; }

        [ForeignKey("PackageId")]
        public Package? Package { get; set; }

        [Column("start_date")]
        public DateTime? StartDate { get; set; }

        [Column("end_date")]
        public DateTime? EndDate { get; set; }

        [Column("status")]
        [MaxLength(20)]
        public string Status { get; set; } = "pending"; // active, expired, paused, cancelled

        [Column("payment_status")]
        [MaxLength(20)]
        public string PaymentStatus { get; set; } = "pending";
    }

    [Table("invoices")]
    public class Invoice : BaseEntity
    {
        [Required]
        [Column("member_id")]
        public int MemberId { get; set; }

        [ForeignKey("MemberId")]
        public Member? Member { get; set; }

        [Column("subscription_id")]
        public int? SubscriptionId { get; set; }

        [ForeignKey("SubscriptionId")]
        public Subscription? Subscription { get; set; }

        [Column("amount")]
        public decimal Amount { get; set; }

        [Column("status")]
        [MaxLength(20)]
        public string Status { get; set; } = "pending"; // pending, paid, cancelled

        [Column("notes")]
        public string? Notes { get; set; }
    }

    [Table("payments")]
    public class Payment : BaseEntity
    {
        [Required]
        [Column("invoice_id")]
        public int InvoiceId { get; set; }

        [ForeignKey("InvoiceId")]
        public Invoice? Invoice { get; set; }

        [Column("amount")]
        public decimal Amount { get; set; }

        [Column("payment_method")]
        [MaxLength(50)]
        public string PaymentMethod { get; set; } = "cash";

        [MaxLength(100)]
        [Column("transaction_id")]
        public string? TransactionId { get; set; }

        [MaxLength(100)]
        [Column("idempotency_key")]
        public string? IdempotencyKey { get; set; } // Chống thanh toán đúp

        [Column("status")]
        [MaxLength(20)]
        public string Status { get; set; } = "success"; 
    }
}
