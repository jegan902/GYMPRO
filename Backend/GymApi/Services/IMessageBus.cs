namespace GymApi.Services
{
    // Interface mô phỏng hệ thống Event Bus (RabbitMQ/Kafka)
    public interface IMessageBus
    {
        Task PublishEventAsync<T>(string topic, T message);
        Task SendToDeadLetterQueueAsync<T>(string topic, T message, string errorReason);
    }

    public class MockMessageBus : IMessageBus
    {
        private readonly ILogger<MockMessageBus> _logger;

        public MockMessageBus(ILogger<MockMessageBus> logger)
        {
            _logger = logger;
        }

        public Task PublishEventAsync<T>(string topic, T message)
        {
            _logger.LogInformation($"[MessageBus] Publishing to topic '{topic}'");
            
            // Giả lập lỗi để trigger DLQ với event sinh mạng y tế
            if (topic == "medical.alert.triggered")
            {
                _logger.LogWarning($"[MessageBus] Warning: Failed to deliver critical medical alert!");
                throw new Exception("Network timeout connecting to Medical Service");
            }

            return Task.CompletedTask;
        }

        public Task SendToDeadLetterQueueAsync<T>(string topic, T message, string errorReason)
        {
            _logger.LogError($"[DLQ] Message moved to Dead Letter Queue. Topic: {topic} | Reason: {errorReason}");
            // Thực tế sẽ lưu vào Queue/DB hoặc DLX của RabbitMQ để job khác retry liên tục
            return Task.CompletedTask;
        }
    }
}
