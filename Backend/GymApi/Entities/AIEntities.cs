using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GymApi.Entities
{
    [Table("health_metrics")]
    public class HealthMetric : BaseEntity
    {
        [Required]
        [Column("member_id")]
        public int MemberId { get; set; }
        [ForeignKey("MemberId")]
        public Member? Member { get; set; }

        [Column("heart_rate")]
        public int? HeartRate { get; set; }

        [Column("spo2")]
        public decimal? SpO2 { get; set; }

        [Column("bmi")]
        public decimal? Bmi { get; set; }

        [Column("bmr")]
        public decimal? Bmr { get; set; }

        [Column("muscle_mass")]
        public decimal? MuscleMass { get; set; }

        [Column("fat_percentage")]
        public decimal? FatPercentage { get; set; }

        [Column("measurement_date")]
        public DateTime MeasurementDate { get; set; } = DateTime.UtcNow;

        [Column("notes")]
        public string? Notes { get; set; }
    }

    [Table("ai_reports")]
    public class AI_Report : BaseEntity
    {
        [Required]
        [Column("member_id")]
        public int MemberId { get; set; }
        [ForeignKey("MemberId")]
        public Member? Member { get; set; }

        [Required]
        [MaxLength(50)]
        [Column("report_type")]
        public string ReportType { get; set; } = "pose_estimation"; // pose_estimation, workout_recommendation, postural_assessment

        [Required]
        [Column("data", TypeName = "NVARCHAR(MAX)")]
        public string DataJson { get; set; } = "{}"; // Lưu trữ Flexible Schema (JSON)

        [Column("generated_at")]
        public DateTime GeneratedAt { get; set; } = DateTime.UtcNow;

        [Column("is_reviewed")]
        public bool IsReviewed { get; set; } = false;

        [Column("reviewed_by")]
        public int? ReviewedById { get; set; }
        [ForeignKey("ReviewedById")]
        public User? ReviewedBy { get; set; }
    }
}
