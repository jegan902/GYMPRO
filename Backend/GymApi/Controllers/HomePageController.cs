using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using GymApi.Data;
using GymApi.Entities;
using Microsoft.AspNetCore.Authorization;

namespace GymApi.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class HomePageController : ControllerBase
    {
        private readonly GymDbContext _context;

        public HomePageController(GymDbContext context)
        {
            _context = context;
        }

        // --- HERO SECTION ---

        [HttpGet("hero")]
        public async Task<ActionResult<HomePageHero>> GetHero()
        {
            var hero = await _context.HomePageHeroes.FirstOrDefaultAsync();
            if (hero == null)
            {
                // Return a default object if none exists
                return new HomePageHero();
            }
            return hero;
        }

        [Authorize]
        [HttpPut("hero")]
        public async Task<IActionResult> UpdateHero(HomePageHero hero)
        {
            var existingHero = await _context.HomePageHeroes.FirstOrDefaultAsync();
            if (existingHero == null)
            {
                _context.HomePageHeroes.Add(hero);
            }
            else
            {
                existingHero.Title = hero.Title;
                existingHero.Subtitle = hero.Subtitle;
                existingHero.ButtonText = hero.ButtonText;
                existingHero.ImageUrl = hero.ImageUrl;
                existingHero.BackgroundColor = hero.BackgroundColor;
                existingHero.UpdatedAt = DateTime.Now;
            }

            await _context.SaveChangesAsync();
            return NoContent();
        }

        // --- FEATURES SECTION ---

        [HttpGet("features")]
        public async Task<ActionResult<IEnumerable<HomeFeature>>> GetFeatures()
        {
            return await _context.HomeFeatures.OrderBy(f => f.DisplayOrder).ToListAsync();
        }

        [Authorize]
        [HttpPost("features")]
        public async Task<ActionResult<HomeFeature>> CreateFeature(HomeFeature feature)
        {
            _context.HomeFeatures.Add(feature);
            await _context.SaveChangesAsync();
            return CreatedAtAction(nameof(GetFeatures), new { id = feature.Id }, feature);
        }

        [Authorize]
        [HttpPut("features/{id}")]
        public async Task<IActionResult> UpdateFeature(int id, HomeFeature feature)
        {
            if (id != feature.Id) return BadRequest();

            _context.Entry(feature).State = EntityState.Modified;

            try
            {
                await _context.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                if (!FeatureExists(id)) return NotFound();
                else throw;
            }

            return NoContent();
        }

        [Authorize]
        [HttpDelete("features/{id}")]
        public async Task<IActionResult> DeleteFeature(int id)
        {
            var feature = await _context.HomeFeatures.FindAsync(id);
            if (feature == null) return NotFound();

            _context.HomeFeatures.Remove(feature);
            await _context.SaveChangesAsync();

            return NoContent();
        }

        private bool FeatureExists(int id)
        {
            return _context.HomeFeatures.Any(e => e.Id == id);
        }
    }
}
