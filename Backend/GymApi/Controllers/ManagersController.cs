using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using GymApi.Data;
using GymApi.Entities;

namespace GymApi.Controllers
{
    [Route("api/v1/[controller]")]
    [ApiController]
    public class ManagersController : ControllerBase
    {
        private readonly GymDbContext _context;

        public ManagersController(GymDbContext context)
        {
            _context = context;
        }

        [HttpGet]
        public async Task<IActionResult> GetManagers()
        {
            var users = await _context.Users.Where(u => !u.IsDeleted && u.Role != "member").ToListAsync();
            var branches = await _context.Branches.Where(b => !b.IsDeleted).ToListAsync();
            var result = new List<object>();

            foreach (var u in users)
            {
                // [ĐỒNG BỘ NÓNG] Kiểm tra xem user này có đang quản lý chi nhánh nào không
                var managedBranch = branches.FirstOrDefault(b => b.ManagerId == u.Id);
                if (managedBranch != null && u.BranchId != managedBranch.Id)
                {
                    u.BranchId = managedBranch.Id;
                    u.Role = "admin";
                    u.RoleId = 2; // Branch Admin
                    await _context.SaveChangesAsync();
                }

                result.Add(new {
                    id = u.Id,
                    full_name = (u.Email == "admin@gympro.com" && string.IsNullOrEmpty(u.FullName)) ? "Nguyễn Văn Admin" : (u.FullName?.Trim() ?? "Quản trị viên"),
                    email = u.Email,
                    role = u.Role,
                    role_id = u.RoleId,
                    role_name = _context.Roles.Where(r => r.Id == u.RoleId).Select(r => r.Name).FirstOrDefault() ?? u.Role,
                    branch_id = u.BranchId,
                    branch_name = (u.BranchId == null || u.BranchId == 0) ? "Toàn hệ thống" : (branches.FirstOrDefault(b => b.Id == u.BranchId)?.Name ?? "Toàn hệ thống"),
                    avatar = u.Avatar,
                    is_active = u.IsActive,
                    created_at = u.CreatedAt
                });
            }

            return Ok(result);
        }

        [HttpPut("{id}/toggle")]
        public async Task<IActionResult> ToggleManager(int id)
        {
            var user = await _context.Users.FindAsync(id);
            if (user == null || user.IsDeleted) return NotFound(new { message = "User not found" });

            user.IsActive = !user.IsActive;
            await _context.SaveChangesAsync();

            return Ok(new { 
                message = "Trạng thái nhân sự đã được cập nhật", 
                status = user.IsActive
            });
        }

        [HttpGet("roles")]
        public async Task<IActionResult> GetRoles()
        {
            var roles = await _context.Roles
                .Where(r => !r.IsDeleted && (r.Name == "Super Admin" || r.Name == "Branch Admin"))
                .Select(r => new { id = r.Id, name = r.Name })
                .ToListAsync();
            return Ok(roles);
        }

        [HttpPost]
        public async Task<IActionResult> CreateManager([FromBody] ManagerDto dto)
        {
            if (await _context.Users.AnyAsync(u => u.Email == dto.Email))
                return BadRequest(new { message = "Email đã tồn tại trên hệ thống!" });

            var user = new User
            {
                FullName = dto.FullName,
                Email = dto.Email,
                Password = BCrypt.Net.BCrypt.HashPassword(dto.Password ?? "123456"), // Mặc định 123456 nếu trống
                Role = dto.Role ?? "admin",
                RoleId = dto.RoleId,
                BranchId = dto.BranchId,
                IsActive = dto.IsActive,
                CreatedAt = DateTime.UtcNow
            };

            _context.Users.Add(user);
            await _context.SaveChangesAsync();
            return Ok(new { message = "Tạo quản lý mới thành công!" });
        }

        [HttpPut("{id}")]
        public async Task<IActionResult> UpdateManager(int id, [FromBody] ManagerDto dto)
        {
            var user = await _context.Users.FindAsync(id);
            if (user == null || user.IsDeleted) return NotFound(new { message = "Người dùng không tồn tại!" });

            user.FullName = dto.FullName;
            user.Email = dto.Email;
            if (!string.IsNullOrEmpty(dto.Password))
            {
                user.Password = BCrypt.Net.BCrypt.HashPassword(dto.Password);
            }
            user.Role = dto.Role ?? "admin";
            user.RoleId = dto.RoleId;
            user.BranchId = dto.BranchId;
            user.IsActive = dto.IsActive;
            user.UpdatedAt = DateTime.UtcNow;

            await _context.SaveChangesAsync();
            return Ok(new { message = "Cập nhật thông tin quản lý thành công!" });
        }

        [HttpDelete("{id}")]
        public async Task<IActionResult> DeleteManager(int id)
        {
            var user = await _context.Users.FindAsync(id);
            if (user == null || user.IsDeleted) return NotFound(new { message = "Người dùng không tồn tại!" });

            user.IsDeleted = true;
            user.DeletedAt = DateTime.UtcNow;
            user.IsActive = false;
            
            await _context.SaveChangesAsync();
            return Ok(new { message = "Đã xóa quản lý khỏi hệ thống!" });
        }
    }

    public class ManagerDto
    {
        public string FullName { get; set; } = string.Empty;
        public string Email { get; set; } = string.Empty;
        public string? Password { get; set; }
        public string? Role { get; set; }
        public int? RoleId { get; set; }
        public int? BranchId { get; set; }
        public bool IsActive { get; set; } = true;
    }
}
