using Microsoft.AspNetCore.Mvc;
using GymApi.Services;
using GymApi.Authorization;
using Microsoft.AspNetCore.Authorization;

namespace GymApi.Controllers
{
    [ApiController]
    [Route("api/v1/[controller]")]
    [Authorize] // Yêu cầu phải đăng nhập
    public class BookingController : ControllerBase
    {
        private readonly IClassBookingService _bookingService;

        public BookingController(IClassBookingService bookingService)
        {
            _bookingService = bookingService;
        }

        public class BookClassRequest
        {
            public int ClassId { get; set; }
            public int MemberId { get; set; }
            // Tương lai lấy MemberId từ JWT Token Claims thay vì payload
        }

        [HttpPost("book")]
        [RequiresPermission("book_class")] // RBAC Check
        public async Task<IActionResult> BookClass([FromBody] BookClassRequest request)
        {
            // Lấy Idempotency Key từ Header (Frontend truyền lên UUID)
            var idempotencyKey = Request.Headers["Idempotency-Key"].FirstOrDefault();

            try
            {
                var result = await _bookingService.BookClassAsync(request.MemberId, request.ClassId, idempotencyKey ?? string.Empty);
                return Ok(new { message = result });
            }
            catch (Exception ex)
            {
                return StatusCode(500, new { message = "Internal server error", details = ex.Message });
            }
        }

        [HttpPost("cancel")]
        [RequiresPermission("book_class")]
        public async Task<IActionResult> CancelBooking([FromBody] BookClassRequest request)
        {
            try
            {
                var success = await _bookingService.CancelBookingAsync(request.MemberId, request.ClassId);
                if (success)
                {
                    return Ok(new { message = "Booking cancelled successfully. Waitlist has been promoted." });
                }
                return BadRequest(new { message = "Booking not found or already cancelled." });
            }
            catch (Exception ex)
            {
                return StatusCode(500, new { message = "Internal server error", details = ex.Message });
            }
        }
    }
}
