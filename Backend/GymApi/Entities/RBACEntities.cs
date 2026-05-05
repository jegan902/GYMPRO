using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GymApi.Entities
{
    [Table("roles")]
    public class Role : BaseEntity
    {
        [Required]
        [MaxLength(50)]
        [Column("name")]
        public string Name { get; set; } = string.Empty; // e.g., Super Admin, Branch Admin, Staff, Member, User

        [Column("description")]
        [MaxLength(255)]
        public string? Description { get; set; }
        
        public ICollection<RolePermission> RolePermissions { get; set; } = new List<RolePermission>();
    }

    [Table("permissions")]
    public class Permission : BaseEntity
    {
        [Required]
        [MaxLength(100)]
        [Column("name")]
        public string Name { get; set; } = string.Empty; // e.g., manage_branch_staff, use_ai_coach

        [MaxLength(50)]
        [Column("module")]
        public string? Module { get; set; } // e.g., "Branch", "Smart", "Booking"

        [Column("description")]
        [MaxLength(255)]
        public string? Description { get; set; }
    }

    [Table("role_permissions")]
    public class RolePermission : BaseEntity
    {
        [Column("role_id")]
        public int RoleId { get; set; }
        [ForeignKey("RoleId")]
        public Role? Role { get; set; }

        [Column("permission_id")]
        public int PermissionId { get; set; }
        [ForeignKey("PermissionId")]
        public Permission? Permission { get; set; }
    }

    [Table("user_permissions")]
    public class UserPermission : BaseEntity
    {
        [Column("user_id")]
        public int UserId { get; set; }
        [ForeignKey("UserId")]
        public User? User { get; set; }

        [Column("permission_id")]
        public int PermissionId { get; set; }
        [ForeignKey("PermissionId")]
        public Permission? Permission { get; set; }

        [Column("is_granted")]
        public bool IsGranted { get; set; } = true; // Cho phép cấp hoặc cấm (override role)
    }
}
