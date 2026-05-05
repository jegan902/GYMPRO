using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.ChangeTracking;
using Microsoft.EntityFrameworkCore.Diagnostics;
using System.Text.Json;
using GymApi.Entities;

namespace GymApi.Data
{
    public class AuditInterceptor : SaveChangesInterceptor
    {
        // Thường chúng ta sẽ inject IHttpContextAccessor vào đây để lấy UserId và CorrelationId
        // public AuditInterceptor(IHttpContextAccessor httpContextAccessor) ...
        
        public override InterceptionResult<int> SavingChanges(DbContextEventData eventData, InterceptionResult<int> result)
        {
            if (eventData.Context == null) return result;

            ProcessEntities(eventData.Context);
            return base.SavingChanges(eventData, result);
        }

        public override ValueTask<InterceptionResult<int>> SavingChangesAsync(DbContextEventData eventData, InterceptionResult<int> result, CancellationToken cancellationToken = default)
        {
            if (eventData.Context != null)
            {
                ProcessEntities(eventData.Context);
            }
            return base.SavingChangesAsync(eventData, result, cancellationToken);
        }

        private void ProcessEntities(DbContext context)
        {
            var entries = context.ChangeTracker.Entries().ToList();
            var auditEntries = new List<AuditLog>();

            foreach (var entry in entries)
            {
                if (entry.Entity is BaseEntity baseEntity)
                {
                    switch (entry.State)
                    {
                        case EntityState.Added:
                            baseEntity.CreatedAt = DateTime.UtcNow;
                            break;
                        case EntityState.Modified:
                            baseEntity.UpdatedAt = DateTime.UtcNow;
                            break;
                        case EntityState.Deleted:
                            // Chuyển Delete thành Soft Delete
                            entry.State = EntityState.Modified;
                            baseEntity.IsDeleted = true;
                            baseEntity.DeletedAt = DateTime.UtcNow;
                            break;
                    }
                }

                // Bỏ qua nếu không có thay đổi hoặc là AuditLog
                if (entry.Entity is AuditLog || entry.State == EntityState.Detached || entry.State == EntityState.Unchanged)
                    continue;

                // Ghi Audit Log cho các hành động thay đổi dữ liệu
                var auditLog = new AuditLog
                {
                    TableName = entry.Metadata.GetTableName() ?? entry.Metadata.Name,
                    Action = entry.State.ToString(),
                    CreatedAt = DateTime.UtcNow,
                    // Giả lập CorrelationId và UserId, cần lấy từ HttpContext thực tế
                    CorrelationId = "SYS-CORR-001", 
                    UserId = "System" 
                };

                var primaryKey = entry.Properties.FirstOrDefault(p => p.Metadata.IsPrimaryKey());
                if (primaryKey != null)
                {
                    auditLog.PrimaryKey = primaryKey.CurrentValue?.ToString() ?? "";
                }

                if (entry.State == EntityState.Added)
                {
                    auditLog.NewValues = JsonSerializer.Serialize(entry.CurrentValues.ToObject());
                }
                else if (entry.State == EntityState.Deleted || (entry.State == EntityState.Modified && entry.Entity is BaseEntity { IsDeleted: true }))
                {
                    auditLog.Action = "Deleted (Soft)";
                    auditLog.OldValues = JsonSerializer.Serialize(entry.OriginalValues.ToObject());
                }
                else if (entry.State == EntityState.Modified)
                {
                    var changedProperties = entry.Properties.Where(p => p.IsModified).ToList();
                    var oldValues = new Dictionary<string, object?>();
                    var newValues = new Dictionary<string, object?>();

                    foreach (var prop in changedProperties)
                    {
                        oldValues[prop.Metadata.Name] = prop.OriginalValue;
                        newValues[prop.Metadata.Name] = prop.CurrentValue;
                    }

                    auditLog.OldValues = JsonSerializer.Serialize(oldValues);
                    auditLog.NewValues = JsonSerializer.Serialize(newValues);
                    auditLog.AffectedColumns = JsonSerializer.Serialize(changedProperties.Select(p => p.Metadata.Name));
                }

                auditEntries.Add(auditLog);
            }

            if (auditEntries.Any())
            {
                context.Set<AuditLog>().AddRange(auditEntries);
            }
        }
    }
}
