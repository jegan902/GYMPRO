using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using GymApi.Data;
using GymApi.Entities;
using Microsoft.AspNetCore.Authorization;
using System.Security.Claims;

namespace GymApi.Controllers
{
    [Route("api/v1/[controller]")]
    [ApiController]
    [Authorize]
    public class ProfileController : ControllerBase
    {
        private readonly GymDbContext _context;

        public ProfileController(GymDbContext context)
        {
            _context = context;
        }

        [HttpGet]
        public async Task<IActionResult> GetProfile()
        {
            try
            {
                var userIdStr = User.FindFirst(ClaimTypes.NameIdentifier)?.Value;
                if (string.IsNullOrEmpty(userIdStr) || !int.TryParse(userIdStr, out int userId))
                {
                    return Unauthorized(new { message = "Không xác định được người dùng" });
                }

                var user = await _context.Users
                    .FirstOrDefaultAsync(u => u.Id == userId && !u.IsDeleted);

                if (user == null) return NotFound(new { message = "Không tìm thấy người dùng" });

                var member = await _context.Members
                    .FirstOrDefaultAsync(m => m.UserId == userId && !m.IsDeleted);

                var subscription = member != null 
                    ? await _context.Subscriptions
                        .Include(s => s.Package)
                        .OrderByDescending(s => s.CreatedAt)
                        .FirstOrDefaultAsync(s => s.MemberId == member.Id && !s.IsDeleted)
                    : null;

                var metrics = member != null
                    ? await _context.BodyMetrics
                        .OrderByDescending(b => b.MeasuredDate)
                        .FirstOrDefaultAsync(b => b.MemberId == member.Id)
                    : null;

                var attendance = member != null
                    ? await _context.Attendances
                        .Where(a => a.MemberId == member.Id)
                        .OrderByDescending(a => a.CheckInTime)
                        .Take(5)
                        .ToListAsync()
                    : new List<Attendance>();

                var payments = member != null
                    ? await _context.Payments
                        .Include(p => p.Invoice)
                        .Where(p => p.Invoice != null && p.Invoice.MemberId == member.Id)
                        .OrderByDescending(p => p.CreatedAt)
                        .Take(5)
                        .ToListAsync()
                    : new List<Payment>();

                // Xây dựng lịch sử bằng cách sử dụng một cấu trúc dữ liệu trung gian để tránh lỗi kiểu nặc danh
                var historyItems = new List<dynamic>();
                
                foreach (var a in attendance)
                {
                    historyItems.Add(new {
                        type = "Check-in",
                        date = a.CheckInTime.ToString("dd/MM/yyyy"),
                        actualDate = a.CheckInTime,
                        status = "Check",
                        stats = a.CheckOutTime.HasValue ? "OK" : "In"
                    });
                }

                foreach (var p in payments)
                {
                    historyItems.Add(new {
                        type = "Payment",
                        date = p.CreatedAt.ToString("dd/MM/yyyy"),
                        actualDate = p.CreatedAt,
                        status = "Paym",
                        stats = p.Amount.ToString("N0") + " VNĐ"
                    });
                }

                var sortedHistory = historyItems
                    .OrderByDescending(x => x.actualDate)
                    .Take(5)
                    .Select(x => new {
                        x.type,
                        x.date,
                        x.status,
                        x.stats
                    })
                    .ToList();

                return Ok(new {
                    user = new {
                        id = user.Id,
                        fullName = user.FullName,
                        email = user.Email,
                        phone = user.Phone,
                        role = user.Role,
                        avatar = user.Avatar ?? $"https://ui-avatars.com/api/?name={user.FullName}&background=FF5E00&color=fff",
                        createdAt = user.CreatedAt
                    },
                    member = member != null ? new {
                        gender = member.Gender,
                        nationality = member.Nationality ?? "Việt Nam",
                        dateOfBirth = member.DateOfBirth?.ToString("yyyy-MM-dd"),
                        address = member.Address,
                        idCard = member.IdCard,
                        ptSessions = member.PtSessions,
                        status = member.Status
                    } : null,
                    subscription = subscription != null ? new {
                        packageName = subscription.Package?.Name,
                        startDate = subscription.StartDate?.ToString("dd/MM/yyyy"),
                        endDate = subscription.EndDate?.ToString("dd/MM/yyyy"),
                        status = subscription.Status
                    } : null,
                    metrics = metrics != null ? new {
                        weight = metrics.Weight ?? member?.Weight,
                        height = member?.Height,
                        bmi = metrics.Bmi ?? member?.Bmi,
                        bodyFat = metrics.BodyFat ?? member?.BodyFat
                    } : new {
                        weight = (decimal?)(member?.Weight ?? 0),
                        height = (decimal?)(member?.Height ?? 0),
                        bmi = (decimal?)(member?.Bmi ?? 0),
                        bodyFat = (decimal?)(member?.BodyFat ?? 0)
                    },
                    history = sortedHistory
                });
            }
            catch (Exception ex)
            {
                return StatusCode(500, new { 
                    message = "Lỗi hệ thống khi tải hồ sơ", 
                    details = ex.Message,
                    inner = ex.InnerException?.Message,
                    stack = ex.StackTrace 
                });
            }
        }

        [HttpPost("update")]
        public async Task<IActionResult> UpdateProfile([FromForm] UpdateProfileDto dto)
        {
            var userIdStr = User.FindFirst(ClaimTypes.NameIdentifier)?.Value;
            if (string.IsNullOrEmpty(userIdStr) || !int.TryParse(userIdStr, out int userId))
            {
                return Unauthorized(new { message = "Không xác định được người dùng" });
            }

            var user = await _context.Users.FindAsync(userId);
            if (user == null || user.IsDeleted) return NotFound(new { message = "Không tìm thấy người dùng" });

            // Xử lý Upload Avatar
            if (dto.AvatarFile != null)
            {
                var uploadsFolder = Path.Combine(Directory.GetCurrentDirectory(), "wwwroot", "uploads", "avatars");
                if (!Directory.Exists(uploadsFolder)) Directory.CreateDirectory(uploadsFolder);

                var fileName = $"avatar_{userId}_{DateTime.Now.Ticks}{Path.GetExtension(dto.AvatarFile.FileName)}";
                var filePath = Path.Combine(uploadsFolder, fileName);

                using (var stream = new FileStream(filePath, FileMode.Create))
                {
                    await dto.AvatarFile.CopyToAsync(stream);
                }

                user.Avatar = $"/uploads/avatars/{fileName}";
            }

            user.FullName = dto.FullName;
            user.Phone = dto.Phone;
            
            if (!string.IsNullOrEmpty(dto.NewPassword))
            {
                user.Password = BCrypt.Net.BCrypt.HashPassword(dto.NewPassword);
            }

            // Cập nhật thông tin Member
            var member = await _context.Members.FirstOrDefaultAsync(m => m.UserId == userId);
            bool isNewMember = false;
            if (member == null)
            {
                member = new Member { UserId = userId, JoinDate = DateTime.Now };
                _context.Members.Add(member);
                isNewMember = true;
            }

            member.Gender = dto.Gender ?? "male";
            member.Nationality = dto.Nationality;
            if (!string.IsNullOrEmpty(dto.DateOfBirth))
            {
                if (DateTime.TryParse(dto.DateOfBirth, out DateTime dob))
                {
                    member.DateOfBirth = dob;
                }
            }
            member.Address = dto.Address;
            member.IdCard = dto.IdCard;

            // Bổ sung các chỉ số sức khỏe vào Member
            if (dto.Weight.HasValue) member.Weight = dto.Weight;
            if (dto.Height.HasValue) member.Height = dto.Height;
            if (dto.Bmi.HasValue) member.Bmi = dto.Bmi;
            if (dto.BodyFat.HasValue) member.BodyFat = dto.BodyFat;

            user.UpdatedAt = DateTime.UtcNow;

            try 
            {
                await _context.SaveChangesAsync();

                // Đồng thời ghi vào nhật ký BodyMetrics để đảm bảo đồng bộ
                if (dto.Weight.HasValue || dto.Bmi.HasValue)
                {
                    var newMetric = new BodyMetric
                    {
                        MemberId = member.Id,
                        Weight = dto.Weight,
                        Bmi = dto.Bmi,
                        BodyFat = dto.BodyFat,
                        MeasuredDate = DateTime.Now,
                        Notes = "Cập nhật từ hồ sơ"
                    };
                    _context.BodyMetrics.Add(newMetric);
                    await _context.SaveChangesAsync();
                }

                return Ok(new { 
                    message = "Cập nhật hồ sơ thành công!",
                    avatar = user.Avatar 
                });
            }
            catch (Exception ex)
            {
                return BadRequest(new { 
                    message = "Lỗi Database: " + ex.InnerException?.Message ?? ex.Message 
                });
            }
        }
    }

    public class UpdateProfileDto
    {
        public string FullName { get; set; } = string.Empty;
        public string? Phone { get; set; }
        public string? NewPassword { get; set; }
        public IFormFile? AvatarFile { get; set; }
        public string? Gender { get; set; }
        public string? Nationality { get; set; }
        public string? DateOfBirth { get; set; }
        public string? Address { get; set; }
        public string? IdCard { get; set; }
        
        // Stats
        public decimal? Weight { get; set; }
        public decimal? Height { get; set; }
        public decimal? Bmi { get; set; }
        public decimal? BodyFat { get; set; }
    }
}
