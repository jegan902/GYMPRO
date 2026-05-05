using Microsoft.AspNetCore.Mvc;
using GymApi.Services;

namespace GymApi.Controllers
{
    [ApiController]
    [Route("api/v1/[controller]")]
    public class IoTController : ControllerBase
    {
        private readonly IMessageBus _messageBus;
        private readonly ILogger<IoTController> _logger;

        public IoTController(IMessageBus messageBus, ILogger<IoTController> logger)
        {
            _messageBus = messageBus;
            _logger = logger;
        }

        public class SyncConfigReq
        {
            public string DeviceId { get; set; } = string.Empty;
            public int MemberId { get; set; }
            public string RfidTag { get; set; } = string.Empty;
        }

        [HttpPost("sync-machine")]
        public IActionResult SyncMachineConfig([FromBody] SyncConfigReq req)
        {
            // Mô phỏng đồng bộ cấu hình máy tập (vd: độ cao yên xe, tạ) thông qua RFID/BLE
            _logger.LogInformation($"[IoT] Syncing machine {req.DeviceId} for Member {req.MemberId}");
            return Ok(new { message = "Machine synchronized successfully.", config = new { height = 15, weight = 20 } });
        }

        public class MedicalAlertReq
        {
            public int MemberId { get; set; }
            public int HeartRate { get; set; }
            public decimal SpO2 { get; set; }
        }

        [HttpPost("medical-alert")]
        public async Task<IActionResult> TriggerMedicalAlert([FromBody] MedicalAlertReq req)
        {
            // Kiểm tra ngưỡng cảnh báo (vd: nhịp tim quá cao > 180 hoặc SpO2 < 92%)
            if (req.HeartRate > 180 || req.SpO2 < 92)
            {
                var topic = "medical.alert.triggered";
                try
                {
                    _logger.LogWarning($"[IoT] CRITICAL ALERT for Member {req.MemberId}! HR: {req.HeartRate}, SpO2: {req.SpO2}");
                    // Cố gắng gửi đi
                    await _messageBus.PublishEventAsync(topic, req);
                }
                catch (Exception ex)
                {
                    // Đưa vào DLQ để đảm bảo không mất thông báo sinh mạng
                    await _messageBus.SendToDeadLetterQueueAsync(topic, req, ex.Message);
                }

                return StatusCode(202, new { message = "Alert processed." });
            }

            return Ok(new { message = "Vitals are normal." });
        }
    }
}
