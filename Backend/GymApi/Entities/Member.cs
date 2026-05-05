using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GymApi.Entities
{
    [Table("members")]
    public class Member : BaseEntity
    {

        [Required]
        [Column("user_id")]
        public int UserId { get; set; }

        [ForeignKey("UserId")]
        public User? User { get; set; }

        [Column("date_of_birth")]
        public DateTime? DateOfBirth { get; set; }

        [Column("gender")]
        public string Gender { get; set; } = "male";

        [Column("height")]
        public decimal? Height { get; set; }

        [Column("weight")]
        public decimal? Weight { get; set; }

        [Column("bmi")]
        public decimal? Bmi { get; set; }

        [Column("address")]
        public string? Address { get; set; }

        [MaxLength(100)]
        [Column("emergency_contact")]
        public string? EmergencyContact { get; set; }

        [MaxLength(20)]
        [Column("emergency_phone")]
        public string? EmergencyPhone { get; set; }

        [Column("join_date")]
        public DateTime JoinDate { get; set; } = DateTime.Now;

        [Column("status")]
        public string Status { get; set; } = "active";

        [Column("notes")]
        public string? Notes { get; set; }
    }
}
