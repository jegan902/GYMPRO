using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using GymApi.Data;
using GymApi.Entities;
using GymApi.Models;
using Microsoft.AspNetCore.Authorization;

namespace GymApi.Controllers
{
    [Authorize]
    [ApiController]
    [Route("api/[controller]")]
    public class TrainerBookingController : ControllerBase
    {
        private readonly GymDbContext _context;

        public TrainerBookingController(GymDbContext context)
        {
            _context = context;
        }

        // GET: api/TrainerBooking
        [HttpGet]
        public async Task<ActionResult<IEnumerable<TrainerBooking>>> GetAll()
        {
            return await _context.TrainerBookings
                .Include(b => b.Member)
                .Include(b => b.Trainer)
                .ToListAsync();
        }

        // GET: api/TrainerBooking/5
        [HttpGet("{id}")]
        public async Task<ActionResult<TrainerBooking>> GetById(int id)
        {
            var booking = await _context.TrainerBookings
                .Include(b => b.Member)
                .Include(b => b.Trainer)
                .FirstOrDefaultAsync(b => b.Id == id);

            if (booking == null) return NotFound();

            return booking;
        }

        // POST: api/TrainerBooking
        [HttpPost]
        public async Task<ActionResult<TrainerBooking>> Create([FromBody] CreateTrainerBookingRequest request)
        {
            var booking = new TrainerBooking
            {
                MemberId = request.MemberId,
                TrainerId = request.TrainerId,
                StartDate = request.StartDate,
                TotalSessions = request.TotalSessions,
                RemainingSessions = request.TotalSessions,
                Status = "active",
                CreatedAt = DateTime.Now,
                UpdatedAt = DateTime.Now
            };

            _context.TrainerBookings.Add(booking);
            await _context.SaveChangesAsync();

            return CreatedAtAction(nameof(GetById), new { id = booking.Id }, booking);
        }

        // PUT: api/TrainerBooking/5
        [HttpPut("{id}")]
        public async Task<IActionResult> Update(int id, [FromBody] TrainerBooking booking)
        {
            if (id != booking.Id) return BadRequest();

            booking.UpdatedAt = DateTime.Now;
            _context.Entry(booking).State = EntityState.Modified;

            try
            {
                await _context.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                if (!BookingExists(id)) return NotFound();
                throw;
            }

            return NoContent();
        }

        // DELETE: api/TrainerBooking/5
        [HttpDelete("{id}")]
        public async Task<IActionResult> Delete(int id)
        {
            var booking = await _context.TrainerBookings.FindAsync(id);
            if (booking == null) return NotFound();

            _context.TrainerBookings.Remove(booking);
            await _context.SaveChangesAsync();

            return NoContent();
        }

        private bool BookingExists(int id)
        {
            return _context.TrainerBookings.Any(e => e.Id == id);
        }
    }
}