using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GymApi.Entities
{
    public abstract class BaseEntity
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;

        [Column("updated_at")]
        public DateTime? UpdatedAt { get; set; }

        [Column("is_deleted")]
        public bool IsDeleted { get; set; } = false;

        [Column("deleted_at")]
        public DateTime? DeletedAt { get; set; }
    }
}
