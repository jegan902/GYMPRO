using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GymApi.Entities
{
    [Table("branches")]
    public class Branch : BaseEntity
    {
        [Required]
        [MaxLength(100)]
        [Column("name")]
        public string Name { get; set; } = string.Empty;

        [MaxLength(255)]
        [Column("address")]
        public string? Address { get; set; }

        [MaxLength(20)]
        [Column("phone")]
        public string? Phone { get; set; }

        [MaxLength(100)]
        [Column("manager_id")]
        public int? ManagerId { get; set; } // Reference to User

        [Column("is_active")]
        public bool IsActive { get; set; } = true;
    }
}
