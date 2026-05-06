using System;
using System.Collections.Generic;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using GymApi.Entities;
using GymApi.Models;
using GymApi.Services;
using System.Security.Claims;

namespace GymApi.Controllers
{
    [Authorize]
    [ApiController]
    [Route("api/v1/[controller]")]
    public class EquipmentsController : ControllerBase
    {
        private readonly IEquipmentService _equipmentService;

        public EquipmentsController(IEquipmentService equipmentService)
        {
            _equipmentService = equipmentService;
        }

        [HttpGet]
        public async Task<IActionResult> Get(
            [FromQuery] EquipmentStatus? status, 
            [FromQuery] EquipmentCategory? category, 
            [FromQuery] string? search, 
            [FromQuery] int page = 1, 
            [FromQuery] int pageSize = 20,
            [FromQuery] int? branchId = null)
        {
            // Ưu tiên lấy branchId từ URL (dành cho Admin lọc), nếu không có mới lấy theo User
            var effectiveBranchId = branchId ?? GetUserBranchId();
            
            var (items, totalCount) = await _equipmentService.GetEquipmentsAsync(effectiveBranchId, status, category, search, page, pageSize);
            return Ok(new ApiResponse<List<EquipmentListDto>>(items, "Equipments retrieved successfully", true, totalCount, page, pageSize));
        }

        [HttpGet("{id}")]
        public async Task<IActionResult> GetById(int id)
        {
            var branchId = GetUserBranchId();
            var equipment = await _equipmentService.GetEquipmentByIdAsync(id, branchId);
            if (equipment == null) return NotFound(new ApiResponse<object>(null, "Equipment not found", false));
            return Ok(new ApiResponse<EquipmentDetailDto>(equipment));
        }

        [HttpPost]
        public async Task<IActionResult> Create([FromBody] CreateEquipmentDto dto)
        {
            if (!ModelState.IsValid) return BadRequest(ModelState);
            
            var username = User.Identity?.Name ?? "system";
            var equipment = await _equipmentService.CreateEquipmentAsync(dto, username);
            return CreatedAtAction(nameof(GetById), new { id = equipment.Id }, new ApiResponse<EquipmentDetailDto>(equipment, "Equipment created successfully"));
        }

        [HttpPatch("{id}")]
        public async Task<IActionResult> Update(int id, [FromBody] UpdateEquipmentDto dto)
        {
            if (!ModelState.IsValid) return BadRequest(ModelState);

            try
            {
                var branchId = GetUserBranchId();
                var username = User.Identity?.Name ?? "system";
                var equipment = await _equipmentService.UpdateEquipmentAsync(id, dto, branchId, username);
                return Ok(new ApiResponse<EquipmentDetailDto>(equipment, "Equipment updated successfully"));
            }
            catch (KeyNotFoundException)
            {
                return NotFound(new ApiResponse<object>(null, "Equipment not found", false));
            }
            catch (InvalidOperationException ex)
            {
                return BadRequest(new ApiResponse<object>(null, ex.Message, false));
            }
            catch (Exception ex)
            {
                return StatusCode(500, new ApiResponse<object>(null, ex.Message, false));
            }
        }

        [HttpDelete("{id}")]
        public async Task<IActionResult> Delete(int id)
        {
            var branchId = GetUserBranchId();
            var username = User.Identity?.Name ?? "system";
            var success = await _equipmentService.DeleteEquipmentAsync(id, branchId, username);
            if (!success) return NotFound(new ApiResponse<object>(null, "Equipment not found", false));
            return Ok(new ApiResponse<object>(null, "Equipment deleted successfully"));
        }

        [AllowAnonymous]
        [HttpPatch("{id}/status")]
        public async Task<IActionResult> ChangeStatus(int id, [FromBody] StatusUpdateDto dto)
        {
            try
            {
                Console.WriteLine($"[API] Status Update Request for ID {id} to {dto.Status}");
                var username = User.Identity?.Name ?? "system";
                var equipment = await _equipmentService.ChangeStatusAsync(id, dto.Status, username);
                return Ok(new ApiResponse<EquipmentListDto>(equipment, "Status updated successfully"));
            }
            catch (Exception ex)
            {
                Console.WriteLine($"[API ERROR] {ex.Message}");
                return BadRequest(new ApiResponse<object>(null, ex.Message, false));
            }
        }



        [HttpGet("dashboard")]
        public async Task<IActionResult> GetDashboard()
        {
            var branchId = GetUserBranchId();
            var metrics = await _equipmentService.GetDashboardMetricsAsync(branchId);
            return Ok(new ApiResponse<EquipmentDashboardDto>(metrics));
        }

        [HttpPost("{id}/maintenance")]
        public async Task<IActionResult> AddMaintenance(int id, [FromBody] MaintenanceLogDto logDto)
        {
            var branchId = GetUserBranchId();
            var username = User.Identity?.Name ?? "system";
            var success = await _equipmentService.AddMaintenanceLogAsync(id, logDto, branchId, username);
            if (!success) return NotFound(new ApiResponse<object>(null, "Equipment not found", false));
            return Ok(new ApiResponse<object>(null, "Maintenance log added successfully"));
        }

        private int GetUserBranchId()
        {
            var branchIdClaim = User.FindFirst("BranchId")?.Value;
            if (int.TryParse(branchIdClaim, out var branchId)) return branchId;
            return 1; // Default for testing/dev if claim missing
        }
    }

    public class ApiResponse<T>
    {
        public bool Success { get; set; }
        public string Message { get; set; } = string.Empty;
        public T? Data { get; set; }
        public int TotalCount { get; set; }
        public int Page { get; set; }
        public int PageSize { get; set; }
        public int TotalPages => (int)Math.Ceiling((double)TotalCount / (PageSize > 0 ? PageSize : 1));

        public ApiResponse(T? data, string message = "Success", bool success = true, int totalCount = 0, int page = 1, int pageSize = 20)
        {
            Data = data;
            Message = message;
            Success = success;
            TotalCount = totalCount;
            Page = page;
            PageSize = pageSize;
        }
    }
}
