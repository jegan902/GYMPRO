using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using GymApi.Data;
using GymApi.Entities;

namespace GymApi.Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    [Authorize]
    public class PackagesController : ControllerBase
    {
        private readonly GymDbContext _db;

        public PackagesController(GymDbContext db)
        {
            _db = db;
        }

        // ===================== PACKAGES =====================

        /// <summary>
        /// GET /api/Packages - List all packages (with optional active filter)
        /// </summary>
        [HttpGet]
        [AllowAnonymous]
        public async Task<IActionResult> GetAll([FromQuery] bool? activeOnly)
        {
            var query = _db.Packages.Where(p => !p.IsDeleted);

            if (activeOnly == true)
                query = query.Where(p => p.IsActive);

            var packages = await query
                .OrderByDescending(p => p.CreatedAt)
                .Select(p => new
                {
                    p.Id,
                    p.Name,
                    p.Duration,
                    p.Price,
                    p.Description,
                    p.Features,
                    p.IsActive,
                    p.CreatedAt,
                    ActiveSubscriptions = _db.Subscriptions.Count(s => s.PackageId == p.Id && s.Status == "active" && !s.IsDeleted)
                })
                .ToListAsync();

            return Ok(packages);
        }

        /// <summary>
        /// GET /api/Packages/{id}
        /// </summary>
        [HttpGet("{id}")]
        public async Task<IActionResult> GetById(int id)
        {
            var pkg = await _db.Packages
                .Where(p => p.Id == id && !p.IsDeleted)
                .Select(p => new
                {
                    p.Id,
                    p.Name,
                    p.Duration,
                    p.Price,
                    p.Description,
                    p.Features,
                    p.IsActive,
                    p.CreatedAt,
                    ActiveSubscriptions = _db.Subscriptions.Count(s => s.PackageId == p.Id && s.Status == "active" && !s.IsDeleted),
                    Subscriptions = _db.Subscriptions
                        .Where(s => s.PackageId == p.Id && !s.IsDeleted)
                        .Include(s => s.Member).ThenInclude(m => m.User)
                        .Select(s => new
                        {
                            s.Id,
                            s.MemberId,
                            MemberName = s.Member != null && s.Member.User != null ? s.Member.User.FullName : "N/A",
                            s.StartDate,
                            s.EndDate,
                            s.Status,
                            s.PaymentStatus,
                            s.CreatedAt
                        })
                        .OrderByDescending(s => s.CreatedAt)
                        .ToList()
                })
                .FirstOrDefaultAsync();

            if (pkg == null) return NotFound(new { message = "Không tìm thấy gói tập." });
            return Ok(pkg);
        }

        /// <summary>
        /// POST /api/Packages - Create a new package
        /// </summary>
        [HttpPost]
        public async Task<IActionResult> Create([FromBody] PackageCreateDto dto)
        {
            var pkg = new Package
            {
                Name = dto.Name,
                Duration = dto.Duration,
                Price = dto.Price,
                Description = dto.Description,
                Features = dto.Features,
                IsActive = dto.IsActive
            };

            _db.Packages.Add(pkg);
            await _db.SaveChangesAsync();
            return CreatedAtAction(nameof(GetById), new { id = pkg.Id }, new { message = "Tạo gói tập thành công.", id = pkg.Id });
        }

        /// <summary>
        /// PUT /api/Packages/{id} - Update package
        /// </summary>
        [HttpPut("{id}")]
        public async Task<IActionResult> Update(int id, [FromBody] PackageCreateDto dto)
        {
            var pkg = await _db.Packages.FirstOrDefaultAsync(p => p.Id == id && !p.IsDeleted);
            if (pkg == null) return NotFound(new { message = "Không tìm thấy gói tập." });

            pkg.Name = dto.Name;
            pkg.Duration = dto.Duration;
            pkg.Price = dto.Price;
            pkg.Description = dto.Description;
            pkg.Features = dto.Features;
            pkg.IsActive = dto.IsActive;

            await _db.SaveChangesAsync();
            return Ok(new { message = "Cập nhật gói tập thành công." });
        }

        /// <summary>
        /// DELETE /api/Packages/{id} - Soft delete package
        /// </summary>
        [HttpDelete("{id}")]
        public async Task<IActionResult> Delete(int id)
        {
            var pkg = await _db.Packages.FirstOrDefaultAsync(p => p.Id == id && !p.IsDeleted);
            if (pkg == null) return NotFound(new { message = "Không tìm thấy gói tập." });

            // Check active subscriptions
            var activeSubs = await _db.Subscriptions.CountAsync(s => s.PackageId == id && s.Status == "active" && !s.IsDeleted);
            if (activeSubs > 0)
                return BadRequest(new { message = $"Không thể xóa. Gói tập đang có {activeSubs} hội viên đang sử dụng." });

            pkg.IsDeleted = true;
            await _db.SaveChangesAsync();
            return Ok(new { message = "Xóa gói tập thành công." });
        }

        /// <summary>
        /// POST /api/Packages/{id}/toggle - Toggle active/inactive
        /// </summary>
        [HttpPost("{id}/toggle")]
        public async Task<IActionResult> Toggle(int id)
        {
            var pkg = await _db.Packages.FirstOrDefaultAsync(p => p.Id == id && !p.IsDeleted);
            if (pkg == null) return NotFound(new { message = "Không tìm thấy gói tập." });

            pkg.IsActive = !pkg.IsActive;
            await _db.SaveChangesAsync();
            return Ok(new { message = pkg.IsActive ? "Đã kích hoạt gói tập." : "Đã tạm ngừng gói tập.", isActive = pkg.IsActive });
        }

        // ===================== SUBSCRIPTIONS =====================

        /// <summary>
        /// GET /api/Packages/subscriptions - All subscriptions with member + package info
        /// </summary>
        [HttpGet("subscriptions")]
        public async Task<IActionResult> GetSubscriptions([FromQuery] string? status, [FromQuery] int? memberId)
        {
            var query = _db.Subscriptions
                .Where(s => !s.IsDeleted)
                .Include(s => s.Member)
                .Include(s => s.Package)
                .AsQueryable();

            if (!string.IsNullOrEmpty(status))
                query = query.Where(s => s.Status == status);

            if (memberId.HasValue)
                query = query.Where(s => s.MemberId == memberId);

            var subs = await query
                .OrderByDescending(s => s.CreatedAt)
                .Select(s => new
                {
                    s.Id,
                    s.MemberId,
                    MemberName = s.Member != null && s.Member.User != null ? s.Member.User.FullName : "N/A",
                    MemberEmail = s.Member != null && s.Member.User != null ? s.Member.User.Email : "",
                    s.PackageId,
                    PackageName = s.Package != null ? s.Package.Name : "N/A",
                    PackageDuration = s.Package != null ? s.Package.Duration : 0,
                    PackagePrice = s.Package != null ? s.Package.Price : 0,
                    s.StartDate,
                    s.EndDate,
                    s.Status,
                    s.PaymentStatus,
                    s.CreatedAt,
                    DaysRemaining = s.EndDate.HasValue ? (s.EndDate.Value - DateTime.Now).Days : 0
                })
                .ToListAsync();

            return Ok(subs);
        }

        /// <summary>
        /// POST /api/Packages/subscriptions - Register a member to a package
        /// </summary>
        [HttpPost("subscriptions")]
        public async Task<IActionResult> CreateSubscription([FromBody] SubscriptionCreateDto dto)
        {
            var member = await _db.Members.FirstOrDefaultAsync(m => m.Id == dto.MemberId && !m.IsDeleted);
            if (member == null) return NotFound(new { message = "Hội viên không tồn tại." });

            var pkg = await _db.Packages.FirstOrDefaultAsync(p => p.Id == dto.PackageId && !p.IsDeleted && p.IsActive);
            if (pkg == null) return NotFound(new { message = "Gói tập không tồn tại hoặc đã ngừng." });

            // Check for duplicate active subscription
            var existingSub = await _db.Subscriptions
                .AnyAsync(s => s.MemberId == dto.MemberId && s.PackageId == dto.PackageId && s.Status == "active" && !s.IsDeleted);
            if (existingSub)
                return BadRequest(new { message = "Hội viên đã có gói tập này đang hoạt động." });

            var startDate = dto.StartDate ?? DateTime.Now;
            var subscription = new Subscription
            {
                MemberId = dto.MemberId,
                PackageId = dto.PackageId,
                StartDate = startDate,
                EndDate = startDate.AddDays(pkg.Duration),
                Status = "active",
                PaymentStatus = dto.PaymentStatus ?? "pending"
            };

            _db.Subscriptions.Add(subscription);

            // Create invoice
            var invoice = new Invoice
            {
                MemberId = dto.MemberId,
                SubscriptionId = 0, // Will be updated after save
                Amount = pkg.Price,
                Status = dto.PaymentStatus == "paid" ? "paid" : "pending",
                Notes = $"Đăng ký gói {pkg.Name}"
            };
            _db.Invoices.Add(invoice);

            // Update member status to active
            member.Status = "active";

            await _db.SaveChangesAsync();

            // Link invoice to subscription
            invoice.SubscriptionId = subscription.Id;
            await _db.SaveChangesAsync();

            return Ok(new { message = "Đăng ký gói tập thành công.", subscriptionId = subscription.Id });
        }

        /// <summary>
        /// PUT /api/Packages/subscriptions/{id}/status - Update subscription status
        /// </summary>
        [HttpPut("subscriptions/{id}/status")]
        public async Task<IActionResult> UpdateSubscriptionStatus(int id, [FromBody] SubscriptionStatusDto dto)
        {
            var sub = await _db.Subscriptions.FirstOrDefaultAsync(s => s.Id == id && !s.IsDeleted);
            if (sub == null) return NotFound(new { message = "Đăng ký không tồn tại." });

            sub.Status = dto.Status;
            if (!string.IsNullOrEmpty(dto.PaymentStatus))
                sub.PaymentStatus = dto.PaymentStatus;

            await _db.SaveChangesAsync();
            return Ok(new { message = "Cập nhật trạng thái thành công." });
        }

        /// <summary>
        /// DELETE /api/Packages/subscriptions/{id} - Cancel subscription
        /// </summary>
        [HttpDelete("subscriptions/{id}")]
        public async Task<IActionResult> CancelSubscription(int id)
        {
            var sub = await _db.Subscriptions.FirstOrDefaultAsync(s => s.Id == id && !s.IsDeleted);
            if (sub == null) return NotFound(new { message = "Đăng ký không tồn tại." });

            sub.Status = "cancelled";
            await _db.SaveChangesAsync();
            return Ok(new { message = "Đã hủy đăng ký gói tập." });
        }

        // ===================== REVENUE STATS =====================

        /// <summary>
        /// GET /api/Packages/stats - Revenue summary
        /// </summary>
        [HttpGet("stats")]
        public async Task<IActionResult> GetStats()
        {
            var totalPackages = await _db.Packages.CountAsync(p => !p.IsDeleted);
            var activePackages = await _db.Packages.CountAsync(p => !p.IsDeleted && p.IsActive);
            var totalSubscriptions = await _db.Subscriptions.CountAsync(s => !s.IsDeleted);
            var activeSubscriptions = await _db.Subscriptions.CountAsync(s => !s.IsDeleted && s.Status == "active");
            var totalRevenue = await _db.Invoices.Where(i => !i.IsDeleted && i.Status == "paid").SumAsync(i => i.Amount);
            var pendingRevenue = await _db.Invoices.Where(i => !i.IsDeleted && i.Status == "pending").SumAsync(i => i.Amount);

            return Ok(new
            {
                totalPackages,
                activePackages,
                totalSubscriptions,
                activeSubscriptions,
                totalRevenue,
                pendingRevenue
            });
        }
    }

    // ===================== DTOs =====================
    public class PackageCreateDto
    {
        public string Name { get; set; } = string.Empty;
        public int Duration { get; set; }
        public decimal Price { get; set; }
        public string? Description { get; set; }
        public string? Features { get; set; }
        public bool IsActive { get; set; } = true;
    }

    public class SubscriptionCreateDto
    {
        public int MemberId { get; set; }
        public int PackageId { get; set; }
        public DateTime? StartDate { get; set; }
        public string? PaymentStatus { get; set; }
    }

    public class SubscriptionStatusDto
    {
        public string Status { get; set; } = "active";
        public string? PaymentStatus { get; set; }
    }
}
