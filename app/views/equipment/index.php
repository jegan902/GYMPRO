<!-- Equipment List -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Quản lý Thiết bị</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Theo dõi trang thiết bị phòng gym</p>
    </div>
    <?php if (Session::userRole() === 'admin'): ?>
    <a href="<?= URL_ROOT ?>/equipment/create" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Thêm thiết bị</a>
    <?php endif; ?>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-custom stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(0,200,83,0.15)"><i class="bi bi-check-circle" style="color:var(--success)"></i></div>
                <div><div class="stat-number"><?= $totalActive ?></div><div class="stat-label">Hoạt động</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(239,68,68,0.15)"><i class="bi bi-x-circle" style="color:var(--danger)"></i></div>
                <div><div class="stat-number"><?= $totalBroken ?></div><div class="stat-label">Hỏng</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(255,193,7,0.15)"><i class="bi bi-wrench" style="color:var(--warning)"></i></div>
                <div><div class="stat-number"><?= $totalMaint ?></div><div class="stat-label">Bảo trì</div></div>
            </div>
        </div>
    </div>
</div>

<!-- Maintenance Alert -->
<?php if (!empty($needMaint)): ?>
<div class="alert alert-warning mb-4" style="background:rgba(255,193,7,0.1);border:1px solid rgba(255,193,7,0.3);color:var(--warning)">
    <i class="bi bi-exclamation-triangle me-2"></i><strong>Cần bảo trì:</strong>
    <?php foreach ($needMaint as $e): ?>
        <span class="badge bg-warning text-dark ms-1"><?= htmlspecialchars($e->name) ?></span>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Search/Filter -->
<div class="card card-custom mb-4">
    <div class="card-body py-3">
        <form method="GET" class="d-flex gap-3 flex-wrap align-items-end">
            <div><input type="text" name="search" class="form-control form-control-sm" placeholder="Tìm thiết bị..." value="<?= htmlspecialchars($search) ?>" style="min-width:200px"></div>
            <div>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Tất cả trạng thái</option>
                    <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Hoạt động</option>
                    <option value="broken" <?= $status === 'broken' ? 'selected' : '' ?>>Hỏng</option>
                    <option value="maintenance" <?= $status === 'maintenance' ? 'selected' : '' ?>>Bảo trì</option>
                </select>
            </div>
            <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search"></i></button>
        </form>
    </div>
</div>

<?php
    $statusBadge = ['active' => 'success', 'broken' => 'danger', 'maintenance' => 'warning'];
    $statusLabel = ['active' => 'Hoạt động', 'broken' => 'Hỏng', 'maintenance' => 'Bảo trì'];
?>

<!-- Equipment Table -->
<div class="card card-custom">
    <?php if (!empty($equipments)): ?>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead><tr><th>Thiết bị</th><th>Loại</th><th>SL</th><th>Trạng thái</th><th>Mua</th><th>Bảo trì tiếp</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($equipments as $eq): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($eq->name) ?></strong></td>
                    <td><span class="text-muted"><?= htmlspecialchars($eq->category ?? '--') ?></span></td>
                    <td><?= $eq->quantity ?></td>
                    <td><span class="badge bg-<?= $statusBadge[$eq->status] ?? 'secondary' ?>"><?= $statusLabel[$eq->status] ?? $eq->status ?></span></td>
                    <td><?= $eq->purchase_date ? date('d/m/Y', strtotime($eq->purchase_date)) : '--' ?></td>
                    <td>
                        <?php if ($eq->next_maintenance_date): ?>
                            <?php $isOverdue = strtotime($eq->next_maintenance_date) <= time(); ?>
                            <span class="<?= $isOverdue ? 'text-warning fw-bold' : 'text-muted' ?>"><?= date('d/m/Y', strtotime($eq->next_maintenance_date)) ?><?= $isOverdue ? ' ⚠' : '' ?></span>
                        <?php else: ?>--<?php endif; ?>
                    </td>
                    <td>
                        <?php if (Session::userRole() === 'admin'): ?>
                        <div class="d-flex gap-1">
                            <a href="<?= URL_ROOT ?>/equipment/edit/<?= $eq->id ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <a href="<?= URL_ROOT ?>/equipment/delete/<?= $eq->id ?>" class="btn btn-sm btn-outline-danger" data-confirm="Xóa thiết bị này?"><i class="bi bi-trash"></i></a>
                        </div>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="card-body text-center text-muted py-5"><i class="bi bi-tools display-4 d-block mb-2"></i>Chưa có thiết bị nào</div>
    <?php endif; ?>
</div>
