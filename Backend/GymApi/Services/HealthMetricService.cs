using GymApi.Data;
using GymApi.Entities;

namespace GymApi.Services
{
    public interface IHealthMetricService
    {
        Task<HealthMetric> AddMetricAsync(int memberId, decimal heightCm, decimal weightKg, int age, string gender);
    }

    public class HealthMetricService : IHealthMetricService
    {
        private readonly GymDbContext _dbContext;

        public HealthMetricService(GymDbContext dbContext)
        {
            _dbContext = dbContext;
        }

        public async Task<HealthMetric> AddMetricAsync(int memberId, decimal heightCm, decimal weightKg, int age, string gender)
        {
            // Tính toán BMI = Weight (kg) / Height^2 (m^2)
            var heightM = heightCm / 100;
            var bmi = weightKg / (heightM * heightM);

            // Tính toán BMR (Mifflin-St Jeor Equation)
            // Nam: 10 * weight(kg) + 6.25 * height(cm) - 5 * age(y) + 5
            // Nữ: 10 * weight(kg) + 6.25 * height(cm) - 5 * age(y) - 161
            decimal bmr = (10 * weightKg) + (6.25m * heightCm) - (5 * age);
            if (gender.ToLower() == "male")
            {
                bmr += 5;
            }
            else
            {
                bmr -= 161;
            }

            var metric = new HealthMetric
            {
                MemberId = memberId,
                Bmi = Math.Round(bmi, 2),
                Bmr = Math.Round(bmr, 2),
                MeasurementDate = DateTime.UtcNow
            };

            _dbContext.HealthMetrics.Add(metric);
            await _dbContext.SaveChangesAsync();

            return metric;
        }
    }
}
