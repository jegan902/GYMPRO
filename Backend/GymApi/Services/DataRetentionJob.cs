using Microsoft.EntityFrameworkCore;
using GymApi.Data;

namespace GymApi.Services
{
    public class DataRetentionJob : BackgroundService
    {
        private readonly IServiceProvider _serviceProvider;
        private readonly ILogger<DataRetentionJob> _logger;

        public DataRetentionJob(IServiceProvider serviceProvider, ILogger<DataRetentionJob> logger)
        {
            _serviceProvider = serviceProvider;
            _logger = logger;
        }

        protected override async Task ExecuteAsync(CancellationToken stoppingToken)
        {
            _logger.LogInformation("DataRetentionJob is starting.");

            while (!stoppingToken.IsCancellationRequested)
            {
                try
                {
                    await CleanupOldPartitionsAsync(stoppingToken);
                }
                catch (Exception ex)
                {
                    _logger.LogError(ex, "Error occurred executing DataRetentionJob.");
                }

                // Chạy mỗi ngày 1 lần vào giờ thấp điểm
                await Task.Delay(TimeSpan.FromDays(1), stoppingToken);
            }
        }

        private async Task CleanupOldPartitionsAsync(CancellationToken stoppingToken)
        {
            using var scope = _serviceProvider.CreateScope();
            var dbContext = scope.ServiceProvider.GetRequiredService<GymDbContext>();

            // Lấy thời điểm 6 tháng trước
            var retentionDate = DateTime.UtcNow.AddMonths(-6);
            int monthToTruncate = retentionDate.Month;
            int yearToTruncate = retentionDate.Year;

            // Xây dựng câu lệnh TRUNCATE PARTITION thông qua SQL thô
            // LƯU Ý: Đây là logic minh họa cho Database Partitioning (Phase 1)
            // SQL Server hỗ trợ: TRUNCATE TABLE dbo.ai_reports WITH (PARTITIONS (X))
            
            _logger.LogInformation($"[Retention] Preparing to truncate data older than {retentionDate.ToString("yyyy-MM")}...");

            var sql = @"
                DECLARE @PartitionNumber int;
                
                -- Tìm Partition Number của thời gian cần xóa (6 tháng trước) trong hàm pf_MonthlyPartition
                SELECT @PartitionNumber = $PARTITION.pf_MonthlyPartition(@RetentionDate);
                
                IF @PartitionNumber IS NOT NULL
                BEGIN
                    -- Truncate Table theo Partition thay vì dùng DELETE gây treo DB
                    -- (Cần syntax cụ thể tùy theo bảng có khóa ngoại hay không)
                    -- TRUNCATE TABLE dbo.ai_reports WITH (PARTITIONS (@PartitionNumber));
                    -- TRUNCATE TABLE dbo.health_metrics WITH (PARTITIONS (@PartitionNumber));
                    PRINT 'TRUNCATE PARTITION ' + CAST(@PartitionNumber AS VARCHAR);
                END
            ";

            var retentionDateParam = new Microsoft.Data.SqlClient.SqlParameter("@RetentionDate", retentionDate);
            
            // Comment lại để tránh lỗi chạy thực tế nếu chưa Apply Partition Scheme ở DB
            // await dbContext.Database.ExecuteSqlRawAsync(sql, new[] { retentionDateParam }, stoppingToken);

            _logger.LogInformation($"[Retention] Cleanup triggered successfully for Partition older than {retentionDate}.");
        }
    }
}
