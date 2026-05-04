using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GymApi.Entities
{
    [Table("exercise_logs")]
    public class ExerciseLog
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("member_id")]
        public int MemberId { get; set; }

        [ForeignKey("MemberId")]
        public Member? Member { get; set; }

        [Required]
        [Column("exercise_id")]
        public int ExerciseId { get; set; }

        [ForeignKey("ExerciseId")]
        public Exercise? Exercise { get; set; }

        [Column("workout_session_id")]
        public int? WorkoutSessionId { get; set; }

        [ForeignKey("WorkoutSessionId")]
        public WorkoutSession? WorkoutSession { get; set; }

        [Column("set_number")]
        public int SetNumber { get; set; }

        [Column("reps")]
        public int Reps { get; set; }

        [Column("weight")]
        public decimal? Weight { get; set; }

        [Column("log_date")]
        public DateTime LogDate { get; set; }

        [Column("notes")]
        public string? Notes { get; set; }

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;
    }

    [Table("body_metrics")]
    public class BodyMetric
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("member_id")]
        public int MemberId { get; set; }

        [ForeignKey("MemberId")]
        public Member? Member { get; set; }

        [Column("weight")]
        public decimal? Weight { get; set; }

        [Column("body_fat")]
        public decimal? BodyFat { get; set; }

        [Column("muscle_mass")]
        public decimal? MuscleMass { get; set; }

        [Column("bmi")]
        public decimal? Bmi { get; set; }

        [Column("waist")]
        public decimal? Waist { get; set; }

        [Column("chest")]
        public decimal? Chest { get; set; }

        [Column("arm")]
        public decimal? Arm { get; set; }

        [Column("thigh")]
        public decimal? Thigh { get; set; }

        [Column("notes")]
        public string? Notes { get; set; }

        [Column("measured_date")]
        public DateTime MeasuredDate { get; set; }

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;
    }

    [Table("attendance")]
    public class Attendance
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("member_id")]
        public int MemberId { get; set; }

        [ForeignKey("MemberId")]
        public Member? Member { get; set; }

        [Column("check_in_time")]
        public DateTime CheckInTime { get; set; }

        [Column("check_out_time")]
        public DateTime? CheckOutTime { get; set; }

        [Column("method")]
        public string Method { get; set; } = "manual";

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;
    }

    [Table("notifications")]
    public class Notification
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Column("member_id")]
        public int? MemberId { get; set; }

        [ForeignKey("MemberId")]
        public Member? Member { get; set; }

        [Column("user_id")]
        public int? UserId { get; set; }

        [ForeignKey("UserId")]
        public User? User { get; set; }

        [Required]
        [MaxLength(200)]
        [Column("title")]
        public string Title { get; set; } = string.Empty;

        [Required]
        [Column("message")]
        public string Message { get; set; } = string.Empty;

        [Column("type")]
        public string Type { get; set; } = "system";

        [Column("is_read")]
        public bool IsRead { get; set; } = false;

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;
    }

    [Table("equipments")]
    public class Equipment
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [MaxLength(150)]
        [Column("name")]
        public string Name { get; set; } = string.Empty;

        [MaxLength(100)]
        [Column("category")]
        public string? Category { get; set; }

        [Column("status")]
        public string Status { get; set; } = "active";

        [Column("purchase_date")]
        public DateTime? PurchaseDate { get; set; }

        [Column("last_maintenance_date")]
        public DateTime? LastMaintenanceDate { get; set; }

        [Column("next_maintenance_date")]
        public DateTime? NextMaintenanceDate { get; set; }

        [Column("quantity")]
        public int Quantity { get; set; } = 1;

        [Column("note")]
        public string? Note { get; set; }

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;

        [Column("updated_at")]
        public DateTime UpdatedAt { get; set; } = DateTime.Now;
    }

    [Table("settings")]
    public class Setting
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [MaxLength(100)]
        [Column("setting_key")]
        public string SettingKey { get; set; } = string.Empty;

        [Column("setting_value")]
        public string? SettingValue { get; set; }

        [MaxLength(255)]
        [Column("description")]
        public string? Description { get; set; }

        [Column("updated_at")]
        public DateTime UpdatedAt { get; set; } = DateTime.Now;
    }
}
