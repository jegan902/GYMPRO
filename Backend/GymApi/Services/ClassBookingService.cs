using Microsoft.EntityFrameworkCore;
using GymApi.Data;
using GymApi.Entities;

namespace GymApi.Services
{
    public interface IClassBookingService
    {
        Task<string> BookClassAsync(int memberId, int classId, string idempotencyKey);
        Task<bool> CancelBookingAsync(int memberId, int classId);
    }

    public class ClassBookingService : IClassBookingService
    {
        private readonly GymDbContext _dbContext;
        private readonly INotificationService _notificationService;
        private readonly ILogger<ClassBookingService> _logger;

        public ClassBookingService(GymDbContext dbContext, INotificationService notificationService, ILogger<ClassBookingService> logger)
        {
            _dbContext = dbContext;
            _notificationService = notificationService;
            _logger = logger;
        }

        public async Task<string> BookClassAsync(int memberId, int classId, string idempotencyKey)
        {
            // 1. Kiểm tra IdempotencyKey chống double-booking do click nhiều lần
            if (!string.IsNullOrEmpty(idempotencyKey))
            {
                var existingRequest = await _dbContext.ClassBookings
                    .FirstOrDefaultAsync(b => b.IdempotencyKey == idempotencyKey);
                
                if (existingRequest != null) return "Already processed (Idempotency Hit)";
            }

            // 2. Bắt đầu Transaction để đảm bảo tính toàn vẹn dữ liệu
            using var transaction = await _dbContext.Database.BeginTransactionAsync();

            try
            {
                var gymClass = await _dbContext.Classes
                    .FirstOrDefaultAsync(c => c.Id == classId && c.IsActive);

                if (gymClass == null) return "Class not found";

                // Đếm số người đã đặt thành công
                var currentBookingsCount = await _dbContext.ClassBookings
                    .CountAsync(b => b.ClassId == classId && b.Status == "confirmed");

                // Nếu còn chỗ trống -> Booking thành công
                if (currentBookingsCount < gymClass.Capacity)
                {
                    var booking = new ClassBooking
                    {
                        ClassId = classId,
                        MemberId = memberId,
                        Status = "confirmed",
                        IdempotencyKey = idempotencyKey
                    };
                    _dbContext.ClassBookings.Add(booking);
                    await _dbContext.SaveChangesAsync();

                    // Bắn thông báo (Push Notification)
                    var member = await _dbContext.Members.Include(m => m.User).FirstOrDefaultAsync(m => m.Id == memberId);
                    if (member?.User != null)
                    {
                        await _notificationService.SendPushNotificationAsync(member.User.Id, "Booking Confirmed", $"Bạn đã đặt thành công lớp {gymClass.Name}.");
                    }

                    await transaction.CommitAsync();
                    return "Booking confirmed";
                }
                else
                {
                    // Lớp đã đầy -> Đẩy vào Waitlist
                    // Tìm vị trí tiếp theo (Position)
                    var lastPosition = await _dbContext.ClassWaitlists
                        .Where(w => w.ClassId == classId && w.Status == "waiting")
                        .Select(w => (int?)w.Position)
                        .MaxAsync() ?? 0;

                    var waitlist = new ClassWaitlist
                    {
                        ClassId = classId,
                        MemberId = memberId,
                        Position = lastPosition + 1,
                        Status = "waiting"
                    };

                    _dbContext.ClassWaitlists.Add(waitlist);
                    await _dbContext.SaveChangesAsync();

                    await transaction.CommitAsync();
                    return $"Added to waitlist at position {waitlist.Position}";
                }
            }
            catch (Exception ex)
            {
                await transaction.RollbackAsync();
                _logger.LogError(ex, "Error booking class");
                throw;
            }
        }

        public async Task<bool> CancelBookingAsync(int memberId, int classId)
        {
            using var transaction = await _dbContext.Database.BeginTransactionAsync();
            try
            {
                var booking = await _dbContext.ClassBookings
                    .FirstOrDefaultAsync(b => b.ClassId == classId && b.MemberId == memberId && b.Status == "confirmed");

                if (booking == null) return false;

                // 1. Hủy booking hiện tại
                booking.Status = "cancelled";

                // 2. Waitlist Promotion: Tìm người đầu tiên trong Waitlist để đôn lên
                var nextInWaitlist = await _dbContext.ClassWaitlists
                    .Where(w => w.ClassId == classId && w.Status == "waiting")
                    .OrderBy(w => w.Position)
                    .FirstOrDefaultAsync();

                if (nextInWaitlist != null)
                {
                    // Đổi trạng thái trong Waitlist
                    nextInWaitlist.Status = "promoted";

                    // Tạo Booking mới cho người được promote
                    var newBooking = new ClassBooking
                    {
                        ClassId = classId,
                        MemberId = nextInWaitlist.MemberId,
                        Status = "confirmed",
                        IdempotencyKey = Guid.NewGuid().ToString() // Sinh ID mới
                    };
                    _dbContext.ClassBookings.Add(newBooking);

                    // Bắn thông báo Promote cho người dùng may mắn
                    var member = await _dbContext.Members.Include(m => m.User).FirstOrDefaultAsync(m => m.Id == nextInWaitlist.MemberId);
                    if (member?.User != null)
                    {
                        await _notificationService.SendPushNotificationAsync(member.User.Id, "Waitlist Promoted!", $"Bạn đã được đôn lên danh sách chính thức lớp chờ.");
                    }
                }

                await _dbContext.SaveChangesAsync();
                await transaction.CommitAsync();
                return true;
            }
            catch (Exception ex)
            {
                await transaction.RollbackAsync();
                _logger.LogError(ex, "Error cancelling booking");
                throw;
            }
        }
    }
}
