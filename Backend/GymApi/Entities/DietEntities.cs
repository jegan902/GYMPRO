using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GymApi.Entities
{
    [Table("diet_plans")]
    public class DietPlan
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [MaxLength(150)]
        [Column("name")]
        public string Name { get; set; } = string.Empty;

        [Required]
        [Column("goal")]
        public string Goal { get; set; } = string.Empty;

        [Column("total_calories")]
        public int? TotalCalories { get; set; }

        [Column("protein_grams")]
        public int? ProteinGrams { get; set; }

        [Column("carbs_grams")]
        public int? CarbsGrams { get; set; }

        [Column("fat_grams")]
        public int? FatGrams { get; set; }

        [Column("description")]
        public string? Description { get; set; }

        [Column("is_active")]
        public bool IsActive { get; set; } = true;

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;

        [Column("updated_at")]
        public DateTime UpdatedAt { get; set; } = DateTime.Now;

        public ICollection<Meal>? Meals { get; set; }
    }

    [Table("meals")]
    public class Meal
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("diet_plan_id")]
        public int DietPlanId { get; set; }

        [ForeignKey("DietPlanId")]
        public DietPlan? DietPlan { get; set; }

        [Required]
        [MaxLength(100)]
        [Column("meal_name")]
        public string MealName { get; set; } = string.Empty;

        [Required]
        [Column("food_items")]
        public string FoodItems { get; set; } = string.Empty;

        [Column("calories")]
        public int? Calories { get; set; }

        [Column("protein")]
        public decimal? Protein { get; set; }

        [Column("carbs")]
        public decimal? Carbs { get; set; }

        [Column("fat")]
        public decimal? Fat { get; set; }

        [Column("sort_order")]
        public int SortOrder { get; set; } = 0;

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;
    }

    [Table("member_diet_plans")]
    public class MemberDietPlan
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
        [Column("diet_plan_id")]
        public int DietPlanId { get; set; }

        [ForeignKey("DietPlanId")]
        public DietPlan? DietPlan { get; set; }

        [Column("assigned_date")]
        public DateTime AssignedDate { get; set; } = DateTime.Now;

        [Column("status")]
        public string Status { get; set; } = "active";

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;
    }
}
