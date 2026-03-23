<!-- Workout Plans List -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Giáo án tập luyện</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Quản lý và tạo giáo án cho hội viên</p>
    </div>
    <?php if (in_array(Session::userRole(), ['admin', 'staff'])): ?>
    <a href="<?= URL_ROOT ?>/workout/create" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tạo giáo án</a>
    <?php endif; ?>
</div>

<?php if (!empty($plans)): ?>
<div class="row g-4">
    <?php foreach ($plans as $plan): ?>
    <div class="col-xl-4 col-md-6">
        <div class="card card-custom h-100 exercise-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="feature-icon gradient-bg-1"><i class="bi bi-journal-text"></i></div>
                    <span class="badge bg-<?= $plan->level === 'beginner' ? 'success' : ($plan->level === 'advanced' ? 'danger' : 'warning') ?>">
                        <?= ucfirst($plan->level ?? 'beginner') ?>
                    </span>
                </div>
                <h5 class="mb-2"><?= htmlspecialchars($plan->name) ?></h5>
                <p class="text-muted mb-3" style="font-size:0.8rem"><?= htmlspecialchars($plan->description ?? '') ?></p>
                <div class="d-flex gap-3 mb-3" style="font-size:0.8rem">
                    <span class="text-muted"><i class="bi bi-calendar-week me-1"></i><?= $plan->days_per_week ?? 3 ?> ngày/tuần</span>
                    <span class="text-muted"><i class="bi bi-bullseye me-1"></i><?= htmlspecialchars(ucfirst($plan->goal ?? 'general')) ?></span>
                </div>
            </div>
            <div class="card-footer" style="background:transparent;border-top:1px solid var(--border-color);padding:12px 20px">
                <div class="d-flex gap-2">
                    <?php if ($hasPT): ?>
                        <a href="<?= URL_ROOT ?>/workout/show/<?= $plan->id ?>" class="btn btn-sm btn-outline-primary flex-fill"><i class="bi bi-eye me-1"></i>Xem</a>
                    <?php else: ?>
                        <button class="btn btn-sm btn-outline-secondary flex-fill" disabled title="Yêu cầu gói PT"><i class="bi bi-lock me-1"></i>Chỉ gói PT</button>
                    <?php endif; ?>
                    <?php if (Session::userRole() === 'admin'): ?>
                    <a href="<?= URL_ROOT ?>/workout/delete/<?= $plan->id ?>" class="btn btn-sm btn-outline-danger" data-confirm="Xóa giáo án này?"><i class="bi bi-trash"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="text-center text-muted py-5">
    <i class="bi bi-journal-text display-4 d-block mb-2"></i>
    Chưa có giáo án nào
</div>
<?php endif; ?>
