using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GymApi.Entities
{
    [Table("classes")]
    public class Class : BaseEntity
    {
        [Required]
        [MaxLength(100)]
        [Column("name")]
        public string Name { get; set; } = string.Empty;

        [Column("description")]
        public string? Description { get; set; }

        [Column("instructor_id")]
        public int? InstructorId { get; set; }
        [ForeignKey("InstructorId")]
        public User? Instructor { get; set; }

        [Column("start_time")]
        public DateTime StartTime { get; set; }

        [Column("end_time")]
        public DateTime EndTime { get; set; }

        [Column("capacity")]
        public int Capacity { get; set; }

        [Column("branch_id")]
        public int BranchId { get; set; }
        [ForeignKey("BranchId")]
        public Branch? Branch { get; set; }

        [Column("is_active")]
        public bool IsActive { get; set; } = true;
    }

    [Table("class_bookings")]
    public class ClassBooking : BaseEntity
    {
        [Required]
        [Column("class_id")]
        public int ClassId { get; set; }
        [ForeignKey("ClassId")]
        public Class? Class { get; set; }

        [Required]
        [Column("member_id")]
        public int MemberId { get; set; }
        [ForeignKey("MemberId")]
        public Member? Member { get; set; }

        [Column("status")]
        [MaxLength(20)]
        public string Status { get; set; } = "confirmed"; // confirmed, cancelled

        [MaxLength(100)]
        [Column("idempotency_key")]
        public string? IdempotencyKey { get; set; } // Chống double-booking
    }

    [Table("class_waitlists")]
    public class ClassWaitlist : BaseEntity
    {
        [Required]
        [Column("class_id")]
        public int ClassId { get; set; }
        [ForeignKey("ClassId")]
        public Class? Class { get; set; }

        [Required]
        [Column("member_id")]
        public int MemberId { get; set; }
        [ForeignKey("MemberId")]
        public Member? Member { get; set; }

        [Column("position")]
        public int Position { get; set; }

        [Column("status")]
        [MaxLength(20)]
        public string Status { get; set; } = "waiting"; // waiting, promoted, cancelled
    }
}
