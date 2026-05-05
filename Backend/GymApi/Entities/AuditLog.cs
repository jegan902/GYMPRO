using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GymApi.Entities
{
    [Table("audit_logs")]
    public class AuditLog
    {
        [Key]
        [Column("id")]
        public long Id { get; set; }

        [Column("table_name")]
        [MaxLength(100)]
        public string TableName { get; set; } = string.Empty;

        [Column("primary_key")]
        [MaxLength(200)]
        public string PrimaryKey { get; set; } = string.Empty;

        [Column("action")]
        [MaxLength(50)]
        public string Action { get; set; } = string.Empty;

        [Column("old_values")]
        public string? OldValues { get; set; }

        [Column("new_values")]
        public string? NewValues { get; set; }

        [Column("affected_columns")]
        public string? AffectedColumns { get; set; }

        [Column("user_id")]
        [MaxLength(100)]
        public string? UserId { get; set; }

        [Column("correlation_id")]
        [MaxLength(100)]
        public string? CorrelationId { get; set; }

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;
    }
}
