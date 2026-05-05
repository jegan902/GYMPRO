using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using GymApi.Data;
using GymApi.Entities;

namespace GymApi.Controllers
{
    [Route("api/v1/[controller]")]
    [ApiController]
    public class DashboardController : ControllerBase
    {
        private readonly GymDbContext _context;

        public DashboardController(GymDbContext context)
        {
            _context = context;
        }

        [HttpGet("stats")]
        public async Task<IActionResult> GetStats([FromQuery] int? branchId)
        {
            var membersQuery = _context.Members.Where(m => !m.IsDeleted);
            var paymentsQuery = _context.Payments.Where(p => p.Status == "success");
            var classesQuery = _context.Classes.Where(c => !c.IsDeleted);

            if (branchId.HasValue && branchId.Value > 0)
            {
                membersQuery = membersQuery.Where(m => m.User.BranchId == branchId.Value);
                paymentsQuery = paymentsQuery.Where(p => 
                    _context.Invoices.Any(i => i.Id == p.InvoiceId && 
                    _context.Members.Any(m => m.Id == i.MemberId && m.User.BranchId == branchId.Value)));
                classesQuery = classesQuery.Where(c => c.BranchId == branchId.Value);
            }

            var totalMembers = await membersQuery.CountAsync();
            
            var firstDayOfMonth = new DateTime(DateTime.Now.Year, DateTime.Now.Month, 1);
            var monthlyRevenue = await paymentsQuery
                .Where(p => p.CreatedAt >= firstDayOfMonth)
                .SumAsync(p => (double)p.Amount);

            var todayClasses = await classesQuery.CountAsync(c => c.StartTime.Date == DateTime.Today);

            return Ok(new {
                total_members = totalMembers,
                monthly_revenue = monthlyRevenue,
                today_classes = todayClasses,
                medical_alerts = 3 
            });
        }
    }
}
