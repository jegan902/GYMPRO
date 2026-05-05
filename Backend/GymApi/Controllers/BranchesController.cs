using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using GymApi.Data;
using GymApi.Entities;

namespace GymApi.Controllers
{
    [Route("api/v1/[controller]")]
    [ApiController]
    public class BranchesController : ControllerBase
    {
        private readonly GymDbContext _context;

        public BranchesController(GymDbContext context)
        {
            _context = context;
        }

        [HttpGet]
        public async Task<IActionResult> GetBranches()
        {
            var branches = await _context.Branches.Where(b => !b.IsDeleted).ToListAsync();
            var result = new List<object>();

            foreach (var b in branches)
            {
                // [ĐỒNG BỘ NÓNG] Đảm bảo manager luôn ở đúng chi nhánh của mình
                if (b.ManagerId.HasValue)
                {
                    var manager = await _context.Users.FindAsync(b.ManagerId.Value);
                    if (manager != null && manager.BranchId != b.Id)
                    {
                        manager.BranchId = b.Id;
                        manager.Role = "admin";
                        manager.RoleId = 2; // Branch Admin
                        await _context.SaveChangesAsync();
                    }
                }

                var mCount = await _context.Members.CountAsync(m => _context.Users.Any(u => u.Id == m.UserId && u.BranchId == b.Id));
                var revAmount = await _context.Payments
                    .Where(p => p.Status == "success" && 
                               _context.Invoices.Any(i => i.Id == p.InvoiceId && 
                               _context.Members.Any(m => m.Id == i.MemberId && 
                               _context.Users.Any(u => u.Id == m.UserId && u.BranchId == b.Id))))
                    .SumAsync(p => (double?)p.Amount) ?? 0;

                result.Add(new {
                    id = b.Id,
                    name = b.Name,
                    address = b.Address ?? "Chưa cập nhật địa chỉ",
                    phone = b.Phone,
                    status = b.IsActive ? "active" : "inactive",
                    is_active = b.IsActive,
                    manager_id = b.ManagerId,
                    manager = _context.Users.Where(u => u.Id == b.ManagerId)
                        .Select(u => (u.Email == "admin@gympro.com" && string.IsNullOrEmpty(u.FullName)) ? "Nguyễn Văn Admin" : (u.FullName ?? "Chưa có quản lý"))
                        .FirstOrDefault()?.Trim() ?? "Chưa có quản lý",
                    manager_avatar = _context.Users.Where(u => u.Id == b.ManagerId).Select(u => u.Avatar).FirstOrDefault(),
                    members_count = mCount,
                    revenue = revAmount.ToString("N0") + " VNĐ"
                });
            }

            return Ok(result);
        }

        [HttpGet("managers")]
        public async Task<IActionResult> GetManagers()
        {
            var managers = await _context.Users
                .Where(u => !u.IsDeleted && u.Role != "member" && u.Role != "user") // Chỉ lấy những người có quyền quản lý
                .Select(u => new { id = u.Id, name = u.FullName })
                .ToListAsync();

            return Ok(managers);
        }

        [HttpPut("{id}/toggle")]
        public async Task<IActionResult> ToggleBranch(int id)
        {
            var branch = await _context.Branches.FindAsync(id);
            if (branch == null || branch.IsDeleted) return NotFound(new { message = "Branch not found" });

            branch.IsActive = !branch.IsActive;
            await _context.SaveChangesAsync();

            return Ok(new { 
                message = "Branch status updated successfully", 
                status = branch.IsActive ? "active" : "inactive" 
            });
        }

        [HttpPost]
        public async Task<IActionResult> CreateBranch([FromBody] BranchDto dto)
        {
            var branch = new Branch
            {
                Name = dto.Name,
                Address = dto.Address,
                Phone = dto.Phone,
                ManagerId = dto.ManagerId,
                IsActive = dto.IsActive,
                CreatedAt = DateTime.UtcNow
            };
            _context.Branches.Add(branch);
            await _context.SaveChangesAsync();

            // [MỚI] Đồng bộ: Nếu có manager, cập nhật BranchId cho User đó
            if (dto.ManagerId.HasValue)
            {
                var managerUser = await _context.Users.FindAsync(dto.ManagerId.Value);
                if (managerUser != null)
                {
                    managerUser.BranchId = branch.Id;
                    await _context.SaveChangesAsync();
                }
            }
            return Ok(new { message = "Branch created successfully", id = branch.Id });
        }

        [HttpPut("{id}")]
        public async Task<IActionResult> UpdateBranch(int id, [FromBody] BranchDto dto)
        {
            var branch = await _context.Branches.FindAsync(id);
            if (branch == null || branch.IsDeleted) return NotFound(new { message = "Branch not found" });

            // [MỚI] Logic bàn giao: Đưa manager cũ về HQ nhưng GIỮ NGUYÊN vai trò Quản lý
            if (branch.ManagerId.HasValue && branch.ManagerId != dto.ManagerId)
            {
                var oldManager = await _context.Users.FindAsync(branch.ManagerId.Value);
                if (oldManager != null)
                {
                    oldManager.BranchId = 1; // Đưa về Hệ thống (HQ)
                    // Không đổi Role, vẫn là Branch Admin để làm quản lý dự phòng
                }
            }

            branch.Name = dto.Name;
            branch.Address = dto.Address;
            branch.Phone = dto.Phone;
            branch.ManagerId = dto.ManagerId;
            branch.IsActive = dto.IsActive;
            branch.UpdatedAt = DateTime.UtcNow;

            // [MỚI] Đồng bộ: Đưa manager mới về chi nhánh này
            if (dto.ManagerId.HasValue)
            {
                var managerUser = await _context.Users.FindAsync(dto.ManagerId.Value);
                if (managerUser != null)
                {
                    managerUser.BranchId = branch.Id;
                }
            }

            await _context.SaveChangesAsync();
            return Ok(new { message = "Branch updated successfully" });
        }

        [HttpDelete("{id}")]
        public async Task<IActionResult> DeleteBranch(int id)
        {
            var branch = await _context.Branches.FindAsync(id);
            if (branch == null || branch.IsDeleted) return NotFound(new { message = "Branch not found" });

            // Soft Delete
            branch.IsDeleted = true;
            branch.DeletedAt = DateTime.UtcNow;
            branch.IsActive = false;
            
            await _context.SaveChangesAsync();
            return Ok(new { message = "Branch deleted successfully" });
        }
    }

    public class BranchDto
    {
        public string Name { get; set; } = string.Empty;
        public string? Address { get; set; }
        public string? Phone { get; set; }
        public int? ManagerId { get; set; }
        public bool IsActive { get; set; } = true;
    }
}
