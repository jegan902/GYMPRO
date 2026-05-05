using Microsoft.AspNetCore.Authorization;
using Microsoft.EntityFrameworkCore;
using GymApi.Data;
using System.Security.Claims;

namespace GymApi.Authorization
{
    public class PermissionRequirement : IAuthorizationRequirement
    {
        public string PermissionName { get; }
        public PermissionRequirement(string permissionName)
        {
            PermissionName = permissionName;
        }
    }

    public class PermissionAuthorizationHandler : AuthorizationHandler<PermissionRequirement>
    {
        private readonly IServiceScopeFactory _scopeFactory;

        public PermissionAuthorizationHandler(IServiceScopeFactory scopeFactory)
        {
            // Inject scope factory vì AuthorizationHandler là singleton
            _scopeFactory = scopeFactory;
        }

        protected override async Task HandleRequirementAsync(AuthorizationHandlerContext context, PermissionRequirement requirement)
        {
            if (context.User.Identity == null || !context.User.Identity.IsAuthenticated)
            {
                return;
            }

            // Giả định User ID được lưu trong NameIdentifier
            var userIdClaim = context.User.Claims.FirstOrDefault(c => c.Type == ClaimTypes.NameIdentifier);
            if (userIdClaim == null || !int.TryParse(userIdClaim.Value, out int userId))
            {
                return;
            }

            using var scope = _scopeFactory.CreateScope();
            var dbContext = scope.ServiceProvider.GetRequiredService<GymDbContext>();

            // Lấy thông tin user kèm Role và phân quyền (bao gồm UserPermission để override)
            var user = await dbContext.Users
                .Include(u => u.RoleNavigation)
                    .ThenInclude(r => r!.RolePermissions)
                        .ThenInclude(rp => rp.Permission)
                .FirstOrDefaultAsync(u => u.Id == userId);

            if (user == null) return;

            // 1. Kiểm tra UserPermission trực tiếp (cấp riêng cho User này)
            var specificPermission = await dbContext.UserPermissions
                .Include(up => up.Permission)
                .FirstOrDefaultAsync(up => up.UserId == userId && up.Permission!.Name == requirement.PermissionName);

            if (specificPermission != null)
            {
                if (specificPermission.IsGranted)
                {
                    context.Succeed(requirement);
                }
                // Nếu IsGranted = false, tức là User này bị CẤM dù Role có cho phép
                return; 
            }

            // 2. Kiểm tra quyền từ Role
            if (user.RoleNavigation != null)
            {
                // Nếu là Super Admin (all_permissions)
                if (user.RoleNavigation.Name == "Super Admin")
                {
                    context.Succeed(requirement);
                    return;
                }

                bool hasRolePermission = user.RoleNavigation.RolePermissions
                    .Any(rp => rp.Permission!.Name == requirement.PermissionName);

                if (hasRolePermission)
                {
                    context.Succeed(requirement);
                    return;
                }
            }
        }
    }

    // Policy Provider tự động map [RequiresPermission("ABC")] thành Policy "Permission_ABC"
    public class PermissionPolicyProvider : IAuthorizationPolicyProvider
    {
        public DefaultAuthorizationPolicyProvider FallbackPolicyProvider { get; }

        public PermissionPolicyProvider(Microsoft.Extensions.Options.IOptions<AuthorizationOptions> options)
        {
            FallbackPolicyProvider = new DefaultAuthorizationPolicyProvider(options);
        }

        public Task<AuthorizationPolicy> GetDefaultPolicyAsync() => FallbackPolicyProvider.GetDefaultPolicyAsync();

        public Task<AuthorizationPolicy?> GetFallbackPolicyAsync() => FallbackPolicyProvider.GetFallbackPolicyAsync();

        public Task<AuthorizationPolicy?> GetPolicyAsync(string policyName)
        {
            if (policyName.StartsWith("Permission_", StringComparison.OrdinalIgnoreCase))
            {
                var permission = policyName.Substring("Permission_".Length);
                var policy = new AuthorizationPolicyBuilder();
                policy.AddRequirements(new PermissionRequirement(permission));
                return Task.FromResult<AuthorizationPolicy?>(policy.Build());
            }

            return FallbackPolicyProvider.GetPolicyAsync(policyName);
        }
    }
}
