using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using GymApi.Data;
using GymApi.Entities;
using GymApi.Services;
using Microsoft.AspNetCore.Authorization;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace GymApi.Controllers
{
    [Authorize]
    [Route("api/[controller]")]
    [ApiController]
    public class MembersController : ControllerBase
    {
        private readonly GymDbContext _context;
        private readonly IHealthMetricService _healthMetricService;

        public MembersController(GymDbContext context, IHealthMetricService healthMetricService)
        {
            _context = context;
            _healthMetricService = healthMetricService;
        }

        // GET: api/Members
        [HttpGet]
        public async Task<ActionResult<IEnumerable<object>>> GetMembers([FromQuery] int? branchId, [FromQuery] string? status, [FromQuery] string? search)
        {
            var query = _context.Members
                .Include(m => m.User)
                .Where(m => !m.IsDeleted && !m.User.IsDeleted);

            if (branchId.HasValue && branchId.Value > 0)
            {
                query = query.Where(m => m.User.BranchId == branchId.Value);
            }

            if (!string.IsNullOrEmpty(status))
            {
                query = query.Where(m => m.Status.ToLower() == status.ToLower());
            }

            if (!string.IsNullOrEmpty(search))
            {
                var searchLower = search.ToLower();
                query = query.Where(m => m.User.FullName.ToLower().Contains(searchLower) || 
                                         m.User.Email.ToLower().Contains(searchLower) || 
                                         m.User.Phone.Contains(searchLower) ||
                                         m.IdCard.Contains(searchLower));
            }

            var members = await query.OrderByDescending(m => m.CreatedAt).ToListAsync();
            
            // Format output for JSON mapping
            return Ok(members.Select(m => new {
                m.Id,
                m.UserId,
                FullName = m.User?.FullName,
                Email = m.User?.Email,
                Phone = m.User?.Phone,
                BranchId = m.User?.BranchId,
                BranchName = m.User?.Branch?.Name,
                IsActive = m.User?.IsActive ?? false,
                m.DateOfBirth,
                m.Gender,
                m.Height,
                m.Weight,
                m.Bmi,
                m.BodyFat,
                m.Address,
                m.EmergencyContact,
                m.EmergencyPhone,
                m.JoinDate,
                m.Status,
                m.Notes,
                m.Nationality,
                m.IdCard,
                m.PtSessions,
                m.CreatedAt,
                m.UpdatedAt
            }));
        }

        // GET: api/Members/5
        [HttpGet("{id}")]
        public async Task<ActionResult<object>> GetMember(int id)
        {
            var member = await _context.Members
                .Include(m => m.User)
                .ThenInclude(u => u.Branch)
                .FirstOrDefaultAsync(m => m.Id == id && !m.IsDeleted);

            if (member == null)
            {
                return NotFound(new { message = "Không tìm thấy hội viên này." });
            }

            // Get historical health metrics for charts
            var metrics = await _context.HealthMetrics
                .Where(hm => hm.MemberId == id && !hm.IsDeleted)
                .OrderBy(hm => hm.MeasurementDate)
                .Select(hm => new {
                    hm.Id,
                    hm.HeartRate,
                    hm.SpO2,
                    hm.Bmi,
                    hm.Bmr,
                    hm.MuscleMass,
                    hm.FatPercentage,
                    hm.MeasurementDate,
                    hm.Notes
                })
                .ToListAsync();

            return Ok(new {
                member.Id,
                member.UserId,
                FullName = member.User?.FullName,
                Email = member.User?.Email,
                Phone = member.User?.Phone,
                BranchId = member.User?.BranchId,
                BranchName = member.User?.Branch?.Name,
                IsActive = member.User?.IsActive ?? false,
                member.DateOfBirth,
                member.Gender,
                member.Height,
                member.Weight,
                member.Bmi,
                member.BodyFat,
                member.Address,
                member.EmergencyContact,
                member.EmergencyPhone,
                member.JoinDate,
                member.Status,
                member.Notes,
                member.Nationality,
                member.IdCard,
                member.PtSessions,
                member.CreatedAt,
                member.UpdatedAt,
                HealthMetricsHistory = metrics
            });
        }

        // POST: api/Members
        [HttpPost]
        public async Task<ActionResult<object>> CreateMember([FromBody] CreateMemberRequest request)
        {
            if (await _context.Users.AnyAsync(u => u.Email.ToLower() == request.Email.Trim().ToLower() && !u.IsDeleted))
            {
                return BadRequest(new { message = "Email này đã được đăng ký trong hệ thống." });
            }

            var memberRole = await _context.Roles.FirstOrDefaultAsync(r => r.Name == "Member");
            var defaultBranch = request.BranchId ?? (await _context.Branches.FirstOrDefaultAsync())?.Id;

            // Create associated User first
            var user = new User
            {
                FullName = request.FullName,
                Email = request.Email.Trim().ToLower(),
                Password = BCrypt.Net.BCrypt.HashPassword(request.Password ?? "123456"),
                Phone = request.Phone,
                Role = "member",
                RoleId = memberRole?.Id,
                BranchId = defaultBranch,
                IsActive = true,
                CreatedAt = DateTime.UtcNow,
                UpdatedAt = DateTime.UtcNow
            };

            _context.Users.Add(user);
            await _context.SaveChangesAsync();

            // Create Member
            var member = new Member
            {
                UserId = user.Id,
                DateOfBirth = request.DateOfBirth,
                Gender = request.Gender,
                Height = request.Height,
                Weight = request.Weight,
                BodyFat = request.BodyFat,
                Address = request.Address,
                EmergencyContact = request.EmergencyContact,
                EmergencyPhone = request.EmergencyPhone,
                JoinDate = DateTime.UtcNow,
                Status = "active",
                Notes = request.Notes,
                Nationality = request.Nationality ?? "Vietnam",
                IdCard = request.IdCard,
                PtSessions = request.PtSessions,
                CreatedAt = DateTime.UtcNow,
                UpdatedAt = DateTime.UtcNow
            };

            // Calculate BMI and BMR if health details are provided
            if (request.Height.HasValue && request.Weight.HasValue && request.DateOfBirth.HasValue)
            {
                int age = DateTime.UtcNow.Year - request.DateOfBirth.Value.Year;
                if (request.DateOfBirth.Value.Date > DateTime.UtcNow.AddYears(-age)) age--;

                var metric = await _healthMetricService.AddMetricAsync(
                    member.Id, 
                    request.Height.Value, 
                    request.Weight.Value, 
                    age, 
                    request.Gender
                );

                member.Bmi = metric.Bmi;
                // update body fat if provided in initial metric
                if (request.BodyFat.HasValue)
                {
                    var dbMetric = await _context.HealthMetrics.FindAsync(metric.Id);
                    if (dbMetric != null)
                    {
                        dbMetric.FatPercentage = request.BodyFat;
                        await _context.SaveChangesAsync();
                    }
                }
            }

            _context.Members.Add(member);
            await _context.SaveChangesAsync();

            return CreatedAtAction(nameof(GetMember), new { id = member.Id }, new {
                member.Id,
                member.UserId,
                FullName = user.FullName,
                Email = user.Email,
                message = "Tạo tài khoản hội viên thành công!"
            });
        }

        // PUT: api/Members/5
        [HttpPut("{id}")]
        public async Task<IActionResult> UpdateMember(int id, [FromBody] UpdateMemberRequest request)
        {
            var member = await _context.Members
                .Include(m => m.User)
                .FirstOrDefaultAsync(m => m.Id == id && !m.IsDeleted);

            if (member == null)
            {
                return NotFound(new { message = "Không tìm thấy hội viên." });
            }

            var user = member.User;
            if (user == null)
            {
                return BadRequest(new { message = "Hội viên không liên kết với tài khoản người dùng hợp lệ." });
            }

            // Update user details
            user.FullName = request.FullName;
            user.Phone = request.Phone;
            user.BranchId = request.BranchId;
            user.IsActive = request.IsActive;
            user.UpdatedAt = DateTime.UtcNow;

            // Check if height/weight has changed to add new metric log
            bool heightWeightChanged = 
                (request.Height.HasValue && request.Height != member.Height) || 
                (request.Weight.HasValue && request.Weight != member.Weight);

            // Update member details
            member.DateOfBirth = request.DateOfBirth;
            member.Gender = request.Gender;
            member.Height = request.Height;
            member.Weight = request.Weight;
            member.BodyFat = request.BodyFat;
            member.Address = request.Address;
            member.EmergencyContact = request.EmergencyContact;
            member.EmergencyPhone = request.EmergencyPhone;
            member.Nationality = request.Nationality;
            member.IdCard = request.IdCard;
            member.PtSessions = request.PtSessions;
            member.Status = request.Status;
            member.Notes = request.Notes;
            member.UpdatedAt = DateTime.UtcNow;

            if (heightWeightChanged && request.Height.HasValue && request.Weight.HasValue && request.DateOfBirth.HasValue)
            {
                int age = DateTime.UtcNow.Year - request.DateOfBirth.Value.Year;
                if (request.DateOfBirth.Value.Date > DateTime.UtcNow.AddYears(-age)) age--;

                var metric = await _healthMetricService.AddMetricAsync(
                    member.Id, 
                    request.Height.Value, 
                    request.Weight.Value, 
                    age, 
                    request.Gender
                );

                member.Bmi = metric.Bmi;

                // Save body fat to metric log too
                if (request.BodyFat.HasValue)
                {
                    var dbMetric = await _context.HealthMetrics.FindAsync(metric.Id);
                    if (dbMetric != null)
                    {
                        dbMetric.FatPercentage = request.BodyFat;
                    }
                }
            }

            await _context.SaveChangesAsync();

            return Ok(new { message = "Cập nhật hội viên thành công!" });
        }

        // DELETE: api/Members/5
        [HttpDelete("{id}")]
        public async Task<IActionResult> DeleteMember(int id)
        {
            var member = await _context.Members
                .Include(m => m.User)
                .FirstOrDefaultAsync(m => m.Id == id && !m.IsDeleted);

            if (member == null)
            {
                return NotFound(new { message = "Không tìm thấy hội viên." });
            }

            // Soft delete member
            member.IsDeleted = true;
            member.DeletedAt = DateTime.UtcNow;

            // Soft delete associated user as well
            if (member.User != null)
            {
                member.User.IsDeleted = true;
                member.User.DeletedAt = DateTime.UtcNow;
            }

            await _context.SaveChangesAsync();

            return Ok(new { message = "Xóa hội viên khỏi hệ thống thành công!" });
        }

        // POST: api/Members/5/metrics
        [HttpPost("{id}/metrics")]
        public async Task<ActionResult<object>> RecordMetrics(int id, [FromBody] RecordMetricRequest request)
        {
            var member = await _context.Members
                .Include(m => m.User)
                .FirstOrDefaultAsync(m => m.Id == id && !m.IsDeleted);

            if (member == null)
            {
                return NotFound(new { message = "Không tìm thấy hội viên." });
            }

            if (!member.DateOfBirth.HasValue)
            {
                return BadRequest(new { message = "Vui lòng cập nhật Ngày sinh của hội viên trước khi tính toán BMI/BMR." });
            }

            int age = DateTime.UtcNow.Year - member.DateOfBirth.Value.Year;
            if (member.DateOfBirth.Value.Date > DateTime.UtcNow.AddYears(-age)) age--;

            var metric = await _healthMetricService.AddMetricAsync(
                member.Id, 
                request.Height, 
                request.Weight, 
                age, 
                member.Gender
            );

            // Update member current height/weight/bmi/bodyfat
            member.Height = request.Height;
            member.Weight = request.Weight;
            member.Bmi = metric.Bmi;
            if (request.BodyFat.HasValue)
            {
                member.BodyFat = request.BodyFat;
            }
            member.UpdatedAt = DateTime.UtcNow;

            // Save additional parameters to the metric log
            var dbMetric = await _context.HealthMetrics.FindAsync(metric.Id);
            if (dbMetric != null)
            {
                dbMetric.FatPercentage = request.BodyFat;
                dbMetric.HeartRate = request.HeartRate;
                dbMetric.SpO2 = request.SpO2;
                dbMetric.Notes = request.Notes;
                dbMetric.MeasurementDate = DateTime.UtcNow;
            }

            await _context.SaveChangesAsync();

            return Ok(new { 
                message = "Đã cập nhật chỉ số đo lường sức khỏe thành công!",
                metric = new {
                    dbMetric?.Id,
                    dbMetric?.Bmi,
                    dbMetric?.Bmr,
                    dbMetric?.FatPercentage,
                    dbMetric?.HeartRate,
                    dbMetric?.SpO2,
                    dbMetric?.MeasurementDate
                }
            });
        }
    }

    public class CreateMemberRequest
    {
        public string Email { get; set; } = string.Empty;
        public string? Password { get; set; }
        public string FullName { get; set; } = string.Empty;
        public string? Phone { get; set; }
        public int? BranchId { get; set; }
        public DateTime? DateOfBirth { get; set; }
        public string Gender { get; set; } = "male";
        public decimal? Height { get; set; }
        public decimal? Weight { get; set; }
        public decimal? BodyFat { get; set; }
        public string? Address { get; set; }
        public string? EmergencyContact { get; set; }
        public string? EmergencyPhone { get; set; }
        public string? Nationality { get; set; }
        public string? IdCard { get; set; }
        public int PtSessions { get; set; } = 0;
        public string? Notes { get; set; }
    }

    public class UpdateMemberRequest
    {
        public string FullName { get; set; } = string.Empty;
        public string? Phone { get; set; }
        public int? BranchId { get; set; }
        public bool IsActive { get; set; } = true;
        public DateTime? DateOfBirth { get; set; }
        public string Gender { get; set; } = "male";
        public decimal? Height { get; set; }
        public decimal? Weight { get; set; }
        public decimal? BodyFat { get; set; }
        public string? Address { get; set; }
        public string? EmergencyContact { get; set; }
        public string? EmergencyPhone { get; set; }
        public string? Nationality { get; set; }
        public string? IdCard { get; set; }
        public int PtSessions { get; set; } = 0;
        public string? Notes { get; set; }
        public string Status { get; set; } = "active";
    }

    public class RecordMetricRequest
    {
        public decimal Height { get; set; }
        public decimal Weight { get; set; }
        public decimal? BodyFat { get; set; }
        public int? HeartRate { get; set; }
        public decimal? SpO2 { get; set; }
        public string? Notes { get; set; }
    }
}
