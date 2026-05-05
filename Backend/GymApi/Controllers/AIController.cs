using Microsoft.AspNetCore.Mvc;
using GymApi.Data;
using GymApi.Entities;
using System.Text.Json;

namespace GymApi.Controllers
{
    [ApiController]
    [Route("api/v1/[controller]")]
    // [Authorize] - Sử dụng ApiKeyAuthMiddleware (Service-to-Service) thay vì User JWT
    public class AIController : ControllerBase
    {
        private readonly GymDbContext _dbContext;
        private readonly ILogger<AIController> _logger;

        // Giả lập trạng thái Circuit Breaker (Thực tế dùng thư viện Polly)
        private static bool IsCircuitOpen = false;
        private static DateTime CircuitOpenUntil = DateTime.MinValue;

        public AIController(GymDbContext dbContext, ILogger<AIController> logger)
        {
            _dbContext = dbContext;
            _logger = logger;
        }

        public class PoseDataRequest
        {
            public int MemberId { get; set; }
            public string ReportType { get; set; } = string.Empty;
            public JsonElement Data { get; set; }
        }

        [HttpPost("receive-pose-data")]
        public async Task<IActionResult> ReceivePoseData([FromBody] PoseDataRequest request)
        {
            // 1. Kiểm tra Circuit Breaker (Mạch mở => từ chối xử lý)
            if (IsCircuitOpen && DateTime.UtcNow < CircuitOpenUntil)
            {
                _logger.LogWarning("[CircuitBreaker] Khối xử lý AI đang quá tải, kích hoạt Fallback.");
                return StatusCode(503, new { message = "AI Worker is currently overloaded. Fallback to manual entry activated." });
            }
            else if (IsCircuitOpen && DateTime.UtcNow >= CircuitOpenUntil)
            {
                // Reset (Half-open/Closed)
                IsCircuitOpen = false; 
            }

            try
            {
                var report = new AI_Report
                {
                    MemberId = request.MemberId,
                    ReportType = request.ReportType,
                    DataJson = JsonSerializer.Serialize(request.Data),
                    GeneratedAt = DateTime.UtcNow
                };

                _dbContext.AI_Reports.Add(report);
                await _dbContext.SaveChangesAsync();

                return Ok(new { message = "Data received and stored successfully" });
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Error processing AI data.");

                // 2. Kích hoạt Circuit Breaker nếu có lỗi nghiêm trọng (VD: Timeout DB/Quá tải)
                IsCircuitOpen = true;
                CircuitOpenUntil = DateTime.UtcNow.AddMinutes(5); // Mở mạch trong 5 phút

                return StatusCode(500, new { message = "Internal error processing AI data. Circuit breaker opened." });
            }
        }
    }
}
