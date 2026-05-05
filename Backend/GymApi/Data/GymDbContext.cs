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
        public DbSet<Branch> Branches { get; set; }
        public DbSet<Role> Roles { get; set; }
        public DbSet<Permission> Permissions { get; set; }
        public DbSet<RolePermission> RolePermissions { get; set; }
        public DbSet<UserPermission> UserPermissions { get; set; }
        public DbSet<User> Users { get; set; }
        public DbSet<Member> Members { get; set; }
        public DbSet<TrainerBooking> TrainerBookings { get; set; }

        // Financial
        public DbSet<Package> Packages { get; set; }
        public DbSet<Subscription> Subscriptions { get; set; }
        public DbSet<Invoice> Invoices { get; set; }
        public DbSet<Payment> Payments { get; set; }

        // Booking Engine
        public DbSet<Class> Classes { get; set; }
        public DbSet<ClassBooking> ClassBookings { get; set; }
        public DbSet<ClassWaitlist> ClassWaitlists { get; set; }

        // AI & Health
        public DbSet<HealthMetric> HealthMetrics { get; set; }
        public DbSet<AI_Report> AI_Reports { get; set; }

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
        // BodyMetrics đã được thay thế bằng HealthMetrics
        public DbSet<Attendance> Attendances { get; set; }
        public DbSet<Notification> Notifications { get; set; }
        public DbSet<Equipment> Equipments { get; set; }
        public DbSet<Setting> Settings { get; set; }

        // Home Page Content
        public DbSet<HomePageHero> HomePageHeroes { get; set; }
        public DbSet<HomeFeature> HomeFeatures { get; set; }

        // System & Audit
        public DbSet<AuditLog> AuditLogs { get; set; }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            base.OnModelCreating(modelBuilder);

            // Fix Multiple Cascade Paths error in SQL Server
            modelBuilder.Entity<TrainerBooking>()
                .HasOne(tb => tb.Trainer)
                .WithMany()
                .HasForeignKey(tb => tb.TrainerId)
                .OnDelete(DeleteBehavior.Restrict);

            modelBuilder.Entity<Notification>()
                .HasOne(n => n.User)
                .WithMany()
                .HasForeignKey(n => n.UserId)
                .OnDelete(DeleteBehavior.Restrict);

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

            // Global Query Filters (Soft Delete & Tenant RLS in future)
            foreach (var entityType in modelBuilder.Model.GetEntityTypes())
            {
                if (typeof(BaseEntity).IsAssignableFrom(entityType.ClrType))
                {
                    modelBuilder.Entity(entityType.ClrType)
                        .HasQueryFilter(ConvertFilterExpression<BaseEntity>(e => !e.IsDeleted, entityType.ClrType));
                }
            }
        }

        private static System.Linq.Expressions.LambdaExpression ConvertFilterExpression<TInterface>(
            System.Linq.Expressions.Expression<Func<TInterface, bool>> filterExpression, Type entityType)
        {
            var newParam = System.Linq.Expressions.Expression.Parameter(entityType);
            var newBody = ReplacingExpressionVisitor.Replace(filterExpression.Parameters.Single(), newParam, filterExpression.Body);
            return System.Linq.Expressions.Expression.Lambda(newBody, newParam);
        }
    }
    
    // Helper class to replace expression parameters
    internal class ReplacingExpressionVisitor : System.Linq.Expressions.ExpressionVisitor
    {
        private readonly System.Linq.Expressions.Expression _oldValue;
        private readonly System.Linq.Expressions.Expression _newValue;

        public ReplacingExpressionVisitor(System.Linq.Expressions.Expression oldValue, System.Linq.Expressions.Expression newValue)
        {
            _oldValue = oldValue;
            _newValue = newValue;
        }

        public static System.Linq.Expressions.Expression Replace(System.Linq.Expressions.Expression oldValue, System.Linq.Expressions.Expression newValue, System.Linq.Expressions.Expression expression)
        {
            return new ReplacingExpressionVisitor(oldValue, newValue).Visit(expression);
        }

        protected override System.Linq.Expressions.Expression VisitParameter(System.Linq.Expressions.ParameterExpression node)
        {
            if (node == _oldValue)
            {
                return _newValue;
            }
            return base.VisitParameter(node);
        }
    }
}
