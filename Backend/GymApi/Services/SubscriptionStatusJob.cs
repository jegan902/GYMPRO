using Microsoft.EntityFrameworkCore;
using GymApi.Data;

namespace GymApi.Services
{
    public class SubscriptionStatusJob : BackgroundService
    {
        private readonly IServiceProvider _serviceProvider;
        private readonly ILogger<SubscriptionStatusJob> _logger;

        public SubscriptionStatusJob(IServiceProvider serviceProvider, ILogger<SubscriptionStatusJob> logger)
        {
            _serviceProvider = serviceProvider;
            _logger = logger;
        }

        protected override async Task ExecuteAsync(CancellationToken stoppingToken)
        {
            _logger.LogInformation("SubscriptionStatusJob is starting.");

            while (!stoppingToken.IsCancellationRequested)
            {
                try
                {
                    await CheckAndExpireSubscriptionsAsync(stoppingToken);
                }
                catch (Exception ex)
                {
                    _logger.LogError(ex, "Error occurred executing SubscriptionStatusJob.");
                }

                // Chạy mỗi 24 tiếng (hoặc mỗi giờ tùy cấu hình)
                await Task.Delay(TimeSpan.FromHours(24), stoppingToken);
            }

            _logger.LogInformation("SubscriptionStatusJob is stopping.");
        }

        private async Task CheckAndExpireSubscriptionsAsync(CancellationToken stoppingToken)
        {
            using var scope = _serviceProvider.CreateScope();
            var dbContext = scope.ServiceProvider.GetRequiredService<GymDbContext>();

            var now = DateTime.UtcNow;

            // Lấy các gói đang active nhưng đã quá ngày EndDate
            var expiredSubscriptions = await dbContext.Subscriptions
                .Where(s => s.Status == "active" && s.EndDate.HasValue && s.EndDate.Value < now)
                .ToListAsync(stoppingToken);

            if (expiredSubscriptions.Any())
            {
                foreach (var sub in expiredSubscriptions)
                {
                    sub.Status = "expired";
                    // AuditInterceptor sẽ tự động lưu lại sự thay đổi này kèm Old/New Values
                }

                await dbContext.SaveChangesAsync(stoppingToken);
                _logger.LogInformation($"Expired {expiredSubscriptions.Count} subscriptions.");
            }
        }
    }
}
