using Microsoft.AspNetCore.Authorization;

namespace GymApi.Authorization
{
    [AttributeUsage(AttributeTargets.Method | AttributeTargets.Class, AllowMultiple = true)]
    public class RequiresPermissionAttribute : AuthorizeAttribute
    {
        const string POLICY_PREFIX = "Permission_";

        public string PermissionName { get; private set; }

        public RequiresPermissionAttribute(string permissionName)
        {
            PermissionName = permissionName;
            Policy = $"{POLICY_PREFIX}{permissionName}";
        }
    }
}
