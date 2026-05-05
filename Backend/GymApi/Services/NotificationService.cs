namespace GymApi.Services
{
    public interface INotificationService
    {
        Task SendEmailAsync(string toEmail, string subject, string body);
        Task SendPushNotificationAsync(int userId, string title, string message);
        Task SendSmsAsync(string phoneNumber, string message);
    }

    public class NotificationService : INotificationService
    {
        private readonly ILogger<NotificationService> _logger;

        public NotificationService(ILogger<NotificationService> logger)
        {
            _logger = logger;
        }

        public Task SendEmailAsync(string toEmail, string subject, string body)
        {
            // Tích hợp SMTP hoặc SendGrid / AWS SES ở đây
            _logger.LogInformation($"[EMAIL] To: {toEmail} | Subject: {subject} | Body: {body}");
            return Task.CompletedTask;
        }

        public Task SendPushNotificationAsync(int userId, string title, string message)
        {
            // Tích hợp Firebase Cloud Messaging (FCM) hoặc OneSignal
            _logger.LogInformation($"[PUSH] UserId: {userId} | Title: {title} | Message: {message}");
            return Task.CompletedTask;
        }

        public Task SendSmsAsync(string phoneNumber, string message)
        {
            // Tích hợp Twilio, Nexmo hoặc VNPAY SMS
            _logger.LogInformation($"[SMS] Phone: {phoneNumber} | Message: {message}");
            return Task.CompletedTask;
        }
    }
}
