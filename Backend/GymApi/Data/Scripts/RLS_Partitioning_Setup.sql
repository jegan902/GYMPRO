-- ==========================================
-- GYM SYSTEM: ADVANCED DB ARCHITECTURE SCRIPT
-- ==========================================

-- ==========================================
-- 1. ROW-LEVEL SECURITY (RLS) FOR MULTI-TENANT (BRANCH)
-- ==========================================
-- RLS đảm bảo ở tầng Database rằng dữ liệu của chi nhánh này 
-- tuyệt đối không thể bị rò rỉ sang chi nhánh khác.

CREATE SCHEMA Security;
GO

-- Tạo hàm kiểm tra quyền truy cập theo BranchId
-- Backend (.NET) sẽ truyền SESSION_CONTEXT(N'BranchId') vào mỗi DbContext connection.
CREATE FUNCTION Security.fn_tenantRLSPredicate(@BranchId INT)
    RETURNS TABLE
    WITH SCHEMABINDING
AS
    RETURN SELECT 1 AS fn_tenantRLSPredicate_result
    WHERE @BranchId = CAST(SESSION_CONTEXT(N'BranchId') AS INT)
       OR CAST(SESSION_CONTEXT(N'IsSuperAdmin') AS INT) = 1;
GO

-- Áp dụng Security Policy cho các bảng Tenant-based (ví dụ: members, classes)
-- (Sẽ tự động apply lên các bảng sau khi Migrations chạy)
/*
CREATE SECURITY POLICY Security.TenantPolicy_Members
    ADD FILTER PREDICATE Security.fn_tenantRLSPredicate(branch_id) ON dbo.members,
    ADD BLOCK PREDICATE Security.fn_tenantRLSPredicate(branch_id) ON dbo.members
    WITH (STATE = ON);
*/
GO


-- ==========================================
-- 2. DATABASE PARTITIONING (DATA RETENTION POLICY)
-- ==========================================
-- Phân vùng dữ liệu HealthMetrics và AI_Reports theo từng tháng (Monthly Partition)
-- Giúp lệnh dọn dẹp dữ liệu (TRUNCATE PARTITION) chạy mượt mà không khóa DB.

-- Bước 1: Tạo Partition Function chia theo tháng trong năm
CREATE PARTITION FUNCTION pf_MonthlyPartition (DATETIME2)
AS RANGE RIGHT FOR VALUES (
    '2026-01-01', '2026-02-01', '2026-03-01', '2026-04-01',
    '2026-05-01', '2026-06-01', '2026-07-01', '2026-08-01',
    '2026-09-01', '2026-10-01', '2026-11-01', '2026-12-01'
    -- (Job có thể tự động SPLIT thêm range cho các năm tiếp theo)
);
GO

-- Bước 2: Tạo Partition Scheme
-- (Trên Production, nên trỏ các tháng cũ về filegroups nằm trên ổ HDD (Cold Storage) để tối ưu chi phí)
CREATE PARTITION SCHEME ps_MonthlyPartition
AS PARTITION pf_MonthlyPartition
ALL TO ([PRIMARY]);
GO

-- GHI CHÚ CHO MIGRATION:
-- Cần rebuild Clustered Index của các bảng dữ liệu lớn trỏ vào Partition Scheme.
-- Ví dụ:
-- CREATE UNIQUE CLUSTERED INDEX CIX_HealthMetrics ON dbo.health_metrics(id, created_at) ON ps_MonthlyPartition(created_at);
