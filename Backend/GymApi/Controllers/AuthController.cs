using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using Microsoft.IdentityModel.Tokens;
using GymApi.Data;
using GymApi.Entities;
using GymApi.Models;
using System.IdentityModel.Tokens.Jwt;
using System.Security.Claims;
using System.Text;
using BCrypt.Net;

namespace GymApi.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class AuthController : ControllerBase
    {
        private readonly GymDbContext _context;
        private readonly IConfiguration _configuration;
        private readonly Services.IEmailService _emailService;

        public AuthController(GymDbContext context, IConfiguration configuration, Services.IEmailService emailService)
        {
            _context = context;
            _configuration = configuration;
            _emailService = emailService;
        }

        [HttpPost("forgot-password")]
        public async Task<IActionResult> ForgotPassword([FromBody] ForgotPasswordRequest request)
        {
            var email = request.Email.Trim().ToLower();
            var user = await _context.Users.FirstOrDefaultAsync(u => u.Email.ToLower() == email);
            if (user == null) return NotFound(new { message = "Email not found" });

            // Generate 6-digit OTP
            var otp = new Random().Next(100000, 999999).ToString();
            user.OtpCode = otp;
            user.OtpExpiry = DateTime.UtcNow.AddMinutes(10);
            
            await _context.SaveChangesAsync();

            await _emailService.SendEmailAsync(user.Email, "Mã OTP khôi phục mật khẩu - GYMPRO", 
                $"<h3>Mã OTP của bạn là: <b style='color:#FF5E00'>{otp}</b></h3><p>Mã này sẽ hết hạn sau 10 phút.</p>");

            return Ok(new { message = "Mã OTP đã được gửi đến email của bạn" });
        }

        [HttpPost("verify-otp")]
        public async Task<IActionResult> VerifyOtp([FromBody] VerifyOtpRequest request)
        {
            var user = await _context.Users.FirstOrDefaultAsync(u => u.Email == request.Email);
            if (user == null) return NotFound(new { message = "Email not found" });

            if (user.OtpCode != request.Otp || user.OtpExpiry < DateTime.UtcNow)
            {
                return BadRequest(new { message = "Mã OTP không chính xác hoặc đã hết hạn" });
            }

            return Ok(new { message = "Mã OTP hợp lệ" });
        }

        [HttpPost("reset-password")]
        public async Task<IActionResult> ResetPassword([FromBody] ResetPasswordRequest request)
        {
            var user = await _context.Users.FirstOrDefaultAsync(u => u.Email == request.Email);
            if (user == null) return NotFound(new { message = "Email not found" });

            if (user.OtpCode != request.Otp || user.OtpExpiry < DateTime.UtcNow)
            {
                return BadRequest(new { message = "Mã OTP không chính xác hoặc đã hết hạn" });
            }

            user.Password = BCrypt.Net.BCrypt.HashPassword(request.NewPassword);
            user.OtpCode = null; // Clear OTP after success
            user.OtpExpiry = null;
            
            await _context.SaveChangesAsync();

            return Ok(new { message = "Mật khẩu đã được đặt lại thành công" });
        }


        [HttpPost("register")]
        public async Task<IActionResult> Register([FromBody] RegisterRequest request)
        {
            var email = request.Email.Trim().ToLower();
            if (await _context.Users.AnyAsync(u => u.Email.ToLower() == email))
            {
                return BadRequest(new { message = "Email already registered" });
            }

            var userRole = await _context.Roles.FirstOrDefaultAsync(r => r.Name == "User");
            var hqBranch = await _context.Branches.FirstOrDefaultAsync(); // Thường là HQ ID=1

            var user = new User
            {
                Email = email,
                Password = BCrypt.Net.BCrypt.HashPassword(request.Password),
                FullName = request.FullName,
                Phone = request.Phone,
                Role = "user", // Mặc định là user để đợi xét duyệt
                RoleId = userRole?.Id,
                BranchId = hqBranch?.Id,
                IsActive = true,
                CreatedAt = DateTime.Now,
                UpdatedAt = DateTime.Now
            };

            _context.Users.Add(user);
            await _context.SaveChangesAsync();

            // Automatically create a member record if the role is 'user' or 'member'
            if (user.Role.ToLower() == "user" || user.Role.ToLower() == "member")
            {
                var member = new Member
                {
                    UserId = user.Id,
                    Status = "active",
                    CreatedAt = DateTime.Now,
                    UpdatedAt = DateTime.Now
                };
                _context.Members.Add(member);
                await _context.SaveChangesAsync();
            }

            return Ok(new { message = "Registration successful" });
        }


        [HttpPost("login")]
        public async Task<IActionResult> Login([FromBody] LoginRequest request)
        {
            var email = request.Email.Trim().ToLower();
            var user = await _context.Users.FirstOrDefaultAsync(u => u.Email.ToLower() == email);

            if (user == null || !BCrypt.Net.BCrypt.Verify(request.Password, user.Password))
            {
                return Unauthorized(new { message = "Invalid email or password" });
            }

            if (!user.IsActive)
            {
                return BadRequest(new { message = "Account is inactive" });
            }

            var token = GenerateJwtToken(user);

            var roleName = await _context.Roles.Where(r => r.Id == user.RoleId).Select(r => r.Name).FirstOrDefaultAsync() ?? user.Role;

            return Ok(new AuthResponse
            {
                Token = token,
                FullName = user.FullName,
                Role = roleName
            });
        }

        private string GenerateJwtToken(User user)
        {
            var tokenHandler = new JwtSecurityTokenHandler();
            var key = Encoding.ASCII.GetBytes("YourSuperSecretKeyGoesHereForDevelopment");
            var tokenDescriptor = new SecurityTokenDescriptor
            {
                Subject = new ClaimsIdentity(new[]
                {
                    new Claim(ClaimTypes.NameIdentifier, user.Id.ToString()),
                    new Claim(ClaimTypes.Email, user.Email),
                    new Claim(ClaimTypes.Role, user.Role)
                }),
                Expires = DateTime.UtcNow.AddDays(7),
                SigningCredentials = new SigningCredentials(new SymmetricSecurityKey(key), SecurityAlgorithms.HmacSha256Signature)
            };
            var token = tokenHandler.CreateToken(tokenDescriptor);
            return tokenHandler.WriteToken(token);
        }
    }
}
