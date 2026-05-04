using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GymApi.Entities
{
    [Table("muscle_groups")]
    public class MuscleGroup
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [MaxLength(50)]
        [Column("name")]
        public string Name { get; set; } = string.Empty;

        [Required]
        [MaxLength(50)]
        [Column("name_vi")]
        public string NameVi { get; set; } = string.Empty;

        [MaxLength(50)]
        [Column("icon")]
        public string? Icon { get; set; }

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;
    }

    [Table("exercises")]
    public class Exercise
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("muscle_group_id")]
        public int MuscleGroupId { get; set; }

        [ForeignKey("MuscleGroupId")]
        public MuscleGroup? MuscleGroup { get; set; }

        [Required]
        [MaxLength(150)]
        [Column("name")]
        public string Name { get; set; } = string.Empty;

        [Column("description")]
        public string? Description { get; set; }

        [Column("sets_recommended")]
        public int SetsRecommended { get; set; } = 3;

        [MaxLength(20)]
        [Column("reps_recommended")]
        public string RepsRecommended { get; set; } = "10-12";

        [MaxLength(255)]
        [Column("video_url")]
        public string? VideoUrl { get; set; }

        [MaxLength(255)]
        [Column("image_url")]
        public string? ImageUrl { get; set; }

        [Column("level")]
        public string Level { get; set; } = "beginner";

        [MaxLength(100)]
        [Column("equipment")]
        public string? Equipment { get; set; }

        [Column("is_active")]
        public bool IsActive { get; set; } = true;

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;

        [Column("updated_at")]
        public DateTime UpdatedAt { get; set; } = DateTime.Now;
    }

    [Table("workout_plans")]
    public class WorkoutPlan
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [MaxLength(150)]
        [Column("name")]
        public string Name { get; set; } = string.Empty;

        [Column("level")]
        public string Level { get; set; } = "beginner";

        [Column("days_per_week")]
        public int DaysPerWeek { get; set; } = 3;

        [MaxLength(100)]
        [Column("goal")]
        public string? Goal { get; set; }

        [Column("description")]
        public string? Description { get; set; }

        [Column("is_active")]
        public bool IsActive { get; set; } = true;

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;

        [Column("updated_at")]
        public DateTime UpdatedAt { get; set; } = DateTime.Now;

        public ICollection<WorkoutSession>? Sessions { get; set; }
    }

    [Table("workout_sessions")]
    public class WorkoutSession
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("workout_plan_id")]
        public int WorkoutPlanId { get; set; }

        [ForeignKey("WorkoutPlanId")]
        public WorkoutPlan? WorkoutPlan { get; set; }

        [Column("day_number")]
        public int DayNumber { get; set; }

        [Required]
        [MaxLength(100)]
        [Column("session_name")]
        public string SessionName { get; set; } = string.Empty;

        [MaxLength(100)]
        [Column("focus_area")]
        public string? FocusArea { get; set; }

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;

        public ICollection<WorkoutSessionExercise>? Exercises { get; set; }
    }

    [Table("workout_session_exercises")]
    public class WorkoutSessionExercise
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("workout_session_id")]
        public int WorkoutSessionId { get; set; }

        [ForeignKey("WorkoutSessionId")]
        public WorkoutSession? WorkoutSession { get; set; }

        [Required]
        [Column("exercise_id")]
        public int ExerciseId { get; set; }

        [ForeignKey("ExerciseId")]
        public Exercise? Exercise { get; set; }

        [Column("sets")]
        public int Sets { get; set; } = 3;

        [MaxLength(20)]
        [Column("reps")]
        public string Reps { get; set; } = "10-12";

        [Column("rest_seconds")]
        public int RestSeconds { get; set; } = 60;

        [Column("sort_order")]
        public int SortOrder { get; set; } = 0;
    }

    [Table("member_workout_plans")]
    public class MemberWorkoutPlan
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
        [Column("workout_plan_id")]
        public int WorkoutPlanId { get; set; }

        [ForeignKey("WorkoutPlanId")]
        public WorkoutPlan? WorkoutPlan { get; set; }

        [Column("assigned_date")]
        public DateTime AssignedDate { get; set; } = DateTime.Now;

        [Column("status")]
        public string Status { get; set; } = "active";

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;
    }
}
