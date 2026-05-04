using Microsoft.EntityFrameworkCore;
using GymApi.Entities;

namespace GymApi.Data
{
    public class GymDbContext : DbContext
    {
        public GymDbContext(DbContextOptions<GymDbContext> options) : base(options)
        {
        }

        // Auth & Members
        public DbSet<User> Users { get; set; }
        public DbSet<Member> Members { get; set; }
        public DbSet<TrainerBooking> TrainerBookings { get; set; }

        // Financial
        public DbSet<Package> Packages { get; set; }
        public DbSet<MemberPackage> MemberPackages { get; set; }
        public DbSet<Invoice> Invoices { get; set; }

        // Diet
        public DbSet<DietPlan> DietPlans { get; set; }
        public DbSet<Meal> Meals { get; set; }
        public DbSet<MemberDietPlan> MemberDietPlans { get; set; }

        // Workout
        public DbSet<MuscleGroup> MuscleGroups { get; set; }
        public DbSet<Exercise> Exercises { get; set; }
        public DbSet<WorkoutPlan> WorkoutPlans { get; set; }
        public DbSet<WorkoutSession> WorkoutSessions { get; set; }
        public DbSet<WorkoutSessionExercise> WorkoutSessionExercises { get; set; }
        public DbSet<MemberWorkoutPlan> MemberWorkoutPlans { get; set; }

        // Misc
        public DbSet<ExerciseLog> ExerciseLogs { get; set; }
        public DbSet<BodyMetric> BodyMetrics { get; set; }
        public DbSet<Attendance> Attendances { get; set; }
        public DbSet<Notification> Notifications { get; set; }
        public DbSet<Equipment> Equipments { get; set; }
        public DbSet<Setting> Settings { get; set; }

        // Home Page Content
        public DbSet<HomePageHero> HomePageHeroes { get; set; }
        public DbSet<HomeFeature> HomeFeatures { get; set; }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            base.OnModelCreating(modelBuilder);

            // Configure mapping for TIMESTAMP/DATETIME consistency if needed
            foreach (var entityType in modelBuilder.Model.GetEntityTypes())
            {
                var createdAt = entityType.FindProperty("CreatedAt");
                if (createdAt != null)
                {
                    createdAt.SetDefaultValueSql("GETDATE()");
                }

                var updatedAt = entityType.FindProperty("UpdatedAt");
                if (updatedAt != null)
                {
                    updatedAt.SetDefaultValueSql("GETDATE()");
                }
            }
        }
    }
}
