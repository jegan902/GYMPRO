using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GymApi.Entities
{
    [Table("trainer_bookings")]
    public class TrainerBooking : BaseEntity
    {

        [Required]
        [Column("member_id")]
        public int MemberId { get; set; }

        [ForeignKey("MemberId")]
        public Member? Member { get; set; }

        [Required]
        [Column("trainer_id")]
        public int TrainerId { get; set; }

        [ForeignKey("TrainerId")]
        public User? Trainer { get; set; } // Assuming PTs are in the users table with a trainer role

        [Required]
        [Column("start_date")]
        public DateTime StartDate { get; set; }

        [Column("end_date")]
        public DateTime? EndDate { get; set; }

        [Column("total_sessions")]
        public int TotalSessions { get; set; }

        [Column("remaining_sessions")]
        public int RemainingSessions { get; set; }

        [Column("price")]
        public decimal Price { get; set; }

        [Column("status")]
        public string Status { get; set; } = "pending";

        [MaxLength(100)]
        [Column("idempotency_key")]
        public string? IdempotencyKey { get; set; } // Chống double-booking
    }
}
