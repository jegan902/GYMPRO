using System;
using System.Linq;
using GymApi.Entities;

namespace GymApi.Data
{
    public static class DataSeeder
    {
        public static void SeedData(GymDbContext context)
        {
            // Seed Branches
            if (!context.Branches.Any())
            {
                context.Branches.AddRange(
                    new Branch { Name = "HQ Quận 1", Address = "Quận 1, TP.HCM", IsActive = true },
                    new Branch { Name = "Chi nhánh Quận 7", Address = "Quận 7, TP.HCM", IsActive = true }
                );
                context.SaveChanges();
            }

            // Seed Permissions
            if (!context.Permissions.Any())
            {
                context.Permissions.AddRange(
                    new Permission { Name = "view_dashboard", Description = "View Admin Dashboard" },
                    new Permission { Name = "manage_users", Description = "Manage Users and Members" },
                    new Permission { Name = "manage_billing", Description = "Manage Invoices and Payments" },
                    new Permission { Name = "view_ai_reports", Description = "View Medical and AI Reports" }
                );
                context.SaveChanges();
            }

            // Seed Roles
            if (!context.Roles.Any())
            {
                var role = new Role { Name = "Super Admin", Description = "Highest level of access" };
                context.Roles.Add(role);
                context.SaveChanges();

                // Assign all permissions to Super Admin
                var allPermissions = context.Permissions.ToList();
                foreach (var perm in allPermissions)
                {
                    context.RolePermissions.Add(new RolePermission
                    {
                        RoleId = role.Id,
                        PermissionId = perm.Id
                    });
                }
                context.SaveChanges();
            }
                  // --- KHỞI TẠO 5 VAI TRÒ CHÍNH ---
            
            // 1. Super Admin
            var superAdminRole = context.Roles.FirstOrDefault(r => r.Name == "Super Admin");
            if (superAdminRole == null)
            {
                superAdminRole = new Role { Name = "Super Admin", Description = "Highest level of access - Toàn quyền hệ thống" };
                context.Roles.Add(superAdminRole);
            }

            // 2. Branch Admin
            var branchAdminRole = context.Roles.FirstOrDefault(r => r.Name == "Branch Admin");
            if (branchAdminRole == null)
            {
                branchAdminRole = new Role { Name = "Branch Admin", Description = "Quản lý chi nhánh cụ thể" };
                context.Roles.Add(branchAdminRole);
            }

            // 3. Staff/PT
            var staffRole = context.Roles.FirstOrDefault(r => r.Name == "Staff/PT");
            if (staffRole == null)
            {
                staffRole = new Role { Name = "Staff/PT", Description = "Nhân viên / Người hướng dẫn tập luyện" };
                context.Roles.Add(staffRole);
            }

            // 4. Member
            var memberRole = context.Roles.FirstOrDefault(r => r.Name == "Member");
            if (memberRole == null)
            {
                memberRole = new Role { Name = "Member", Description = "Hội viên (Sử dụng các gói nâng cao & chức năng thông minh)" };
                context.Roles.Add(memberRole);
            }

            // 5. User
            // 1. Đảm bảo thực thể Hệ thống (HQ) luôn tồn tại
            var systemHq = context.Branches.OrderBy(b => b.Id).FirstOrDefault();
            if (systemHq == null)
            {
                systemHq = new Branch { Name = "Hệ thống (HQ)", Address = "Toàn hệ thống", Phone = "N/A", IsActive = true };
                context.Branches.Add(systemHq);
                context.SaveChanges();
            }
            else if (systemHq.Name != "Hệ thống (HQ)")
            {
                systemHq.Name = "Hệ thống (HQ)";
                context.SaveChanges();
            }

            // 2. Tạo chi nhánh vật lý HQ Quận 1 riêng biệt
            var physicalBranchQ1 = context.Branches.FirstOrDefault(b => b.Name == "HQ Quận 1");
            if (physicalBranchQ1 == null)
            {
                physicalBranchQ1 = new Branch { Name = "HQ Quận 1", Address = "Số 1, Quận 1, TP.HCM", Phone = "0901234567", IsActive = true };
                context.Branches.Add(physicalBranchQ1);
                context.SaveChanges();
            }
            var userRole = context.Roles.FirstOrDefault(r => r.Name == "User");
            if (userRole == null)
            {
                userRole = new Role { Name = "User", Description = "Khách vãng lai, đăng ký tập gói thường, xem tin tức" };
                context.Roles.Add(userRole);
            }
            context.SaveChanges();

            // --- KHỞI TẠO CHI NHÁNH & NGƯỜI DÙNG HỆ THỐNG ---
            if (systemHq != null)
            {
                // Super Admin mặc định thuộc về Hệ thống (HQ)
                var superAdmin = context.Users.FirstOrDefault(u => u.Email == "admin@gympro.com");
                if (superAdmin == null)
                {
                    context.Users.Add(new User
                    {
                        FullName = "Nguyễn Văn Super Admin",
                        Email = "admin@gympro.com",
                        Password = BCrypt.Net.BCrypt.HashPassword("admin"),
                        Role = "admin",
                        RoleId = superAdminRole.Id,
                        BranchId = systemHq.Id,
                        IsActive = true,
                        Phone = "0999999999"
                    });
                }
                context.SaveChanges();
            }

            if (physicalBranchQ1 != null)
            {
                // Branch Admin mẫu thuộc về chi nhánh HQ Quận 1
                if (!context.Users.Any(u => u.Email == "admin1@gympro.com"))
                {
                    context.Users.Add(new User
                    {
                        FullName = "Trần Quản Lý Q1",
                        Email = "admin1@gympro.com",
                        Password = BCrypt.Net.BCrypt.HashPassword("admin"),
                        Role = "admin",
                        RoleId = branchAdminRole.Id,
                        BranchId = physicalBranchQ1.Id,
                        IsActive = true,
                        Phone = "0911111111"
                    });
                }
                context.SaveChanges();
            }

            // --- DỌN DẸP & ĐỒNG BỘ DỮ LIỆU ---
            var allUsers = context.Users.ToList();
            var firstBranch = context.Branches.FirstOrDefault();
            foreach (var u in allUsers)
            {
                // Chuẩn hóa chuỗi Role và gán RoleId tương ứng
                if (u.Email == "admin@gympro.com" || u.Role == "Super Admin") {
                    u.Role = "admin";
                    u.RoleId = superAdminRole.Id;
                }
                else if (u.Role == "Branch Admin" || (u.Role == "admin" && u.Email != "admin@gympro.com")) {
                    u.Role = "admin";
                    u.RoleId = branchAdminRole.Id;
                }
                else if (u.Role == "Staff/PT" || u.Role == "staff") {
                    u.RoleId = staffRole.Id;
                }
                else if (u.Role == "Member" || u.Role == "member") {
                    u.RoleId = memberRole.Id;
                    u.Role = "member";
                }
                else if (u.Role == "User" || u.Role == "user") {
                    u.RoleId = userRole.Id;
                    u.Role = "user";
                }

                // Gán chi nhánh mặc định nếu thiếu
                if (u.BranchId == null && firstBranch != null) {
                    u.BranchId = firstBranch.Id;
                }
            }
            context.SaveChanges();

            // [MỚI] Đồng bộ cưỡng ép và dọn dẹp triệt để (Đồng bộ cả Role string và RoleId)
            var allUsersToSync = context.Users.Where(u => u.Email != "admin@gympro.com").ToList();
            var managerIds = context.Branches.Where(b => b.ManagerId != null).Select(b => b.ManagerId).ToList();

            foreach (var user in allUsersToSync)
            {
                if (managerIds.Contains(user.Id))
                {
                    // Nếu là manager của chi nhánh nào đó -> Branch Admin (ID = 2)
                    var br = context.Branches.First(b => b.ManagerId == user.Id);
                    user.BranchId = br.Id;
                    user.Role = "admin"; 
                    user.RoleId = 2; 
                }
                else if (user.RoleId != 4) // Nếu không phải manager và không phải hội viên (ID = 4)
                {
                    // Nếu là nhân sự quản lý dự phòng (kiểm tra theo role cũ hoặc tên)
                    if (user.Role == "admin" || user.Role == "Branch Admin" || user.FullName.Contains("Quản Lý") || user.Email.Contains("admin"))
                    {
                        user.BranchId = 1; // Về Hệ thống (HQ)
                        user.Role = "admin";
                        user.RoleId = 2; // Branch Admin
                    }
                    else
                    {
                        // Đưa về trạng thái chờ tại HQ -> User (ID = 5)
                        user.BranchId = 1;
                        user.Role = "user";
                        user.RoleId = 5;
                    }
                }
            }
            context.SaveChanges();

            SeedFinancialData(context, memberRole);
        }

        private static void SeedFinancialData(GymDbContext context, Role memberRole)
        {
            // 1. Seed Packages nếu chưa có
            if (!context.Packages.Any()) {
                var pkgGold = new Package { Name = "Gói Vàng (1 Năm)", Duration = 365, Price = 5000000, Description = "Toàn quyền sử dụng dịch vụ" };
                var pkgSilver = new Package { Name = "Gói Bạc (1 Tháng)", Duration = 30, Price = 500000, Description = "Chỉ sử dụng phòng Gym" };
                context.Packages.AddRange(pkgGold, pkgSilver);
                context.SaveChanges();
            }

            var branches = context.Branches.ToList();
            if (!branches.Any()) return;

            // 2. Tạo 10 tài khoản hội viên mẫu
            string[] memberNames = { "Nguyễn Hoàng Nam", "Lê Thu Thảo", "Trần Minh Quân", "Phạm Hải Yến", "Đặng Quốc Bảo", "Vũ Phương Linh", "Bùi Anh Tuấn", "Ngô Diệp Chi", "Đỗ Hữu Phước", "Trương Mỹ Hạnh" };
            
            for (int i = 0; i < memberNames.Length; i++)
            {
                var email = $"member{i+1}@gmail.com";
                var user = context.Users.FirstOrDefault(u => u.Email == email);
                
                if (user == null)
                {
                    var branch = branches[i % branches.Count];
                    user = new User
                    {
                        FullName = memberNames[i],
                        Email = email,
                        Password = BCrypt.Net.BCrypt.HashPassword("123456"),
                        Role = "member",
                        RoleId = memberRole.Id,
                        BranchId = branch.Id,
                        IsActive = true,
                        Phone = $"090{i}123456",
                        CreatedAt = DateTime.UtcNow.AddMonths(-1)
                    };
                    context.Users.Add(user);
                    context.SaveChanges();
                }
                else
                {
                    user.Role = "member";
                    user.RoleId = memberRole.Id;
                    context.SaveChanges();
                }

                // Kiểm tra Member profile
                var member = context.Members.FirstOrDefault(m => m.UserId == user.Id);
                if (member == null)
                {
                    member = new Member
                    {
                        UserId = user.Id,
                        Status = "active",
                        JoinDate = DateTime.Now.AddMonths(-1),
                        Gender = i % 2 == 0 ? "male" : "female"
                    };
                    context.Members.Add(member);
                    context.SaveChanges();
                }

                // 3. Tạo hóa đơn nếu chưa có
                if (!context.Invoices.Any(inv => inv.MemberId == member.Id))
                {
                    var amount = i % 2 == 0 ? 5000000 : 500000;
                    var invoice = new Invoice 
                    { 
                        MemberId = member.Id, 
                        Amount = amount, 
                        Status = "paid", 
                        CreatedAt = DateTime.UtcNow.AddDays(-10 + i) 
                    };
                    context.Invoices.Add(invoice);
                    context.SaveChanges();

                    var payment = new Payment 
                    { 
                        InvoiceId = invoice.Id, 
                        Amount = amount, 
                        Status = "success", 
                        CreatedAt = DateTime.UtcNow.AddDays(-10 + i), 
                        PaymentMethod = "Chuyển khoản" 
                    };
                    context.Payments.Add(payment);
                    context.SaveChanges();
                }
            }
        }
    }
}
