<!-- Diet Plans List -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Kế hoạch Dinh dưỡng</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Quản lý chế độ ăn cho hội viên</p>
    </div>
    <?php if (in_array(Session::userRole(), ['admin', 'staff'])): ?>
    <a href="<?= URL_ROOT ?>/diet/create" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tạo kế hoạch</a>
    <?php endif; ?>
</div>

<?php
    $goalLabels = ['lose_fat' => 'Giảm mỡ', 'gain_weight' => 'Tăng cân', 'build_muscle' => 'Tăng cơ', 'maintain' => 'Duy trì'];
    $goalColors = ['lose_fat' => 'danger', 'gain_weight' => 'warning', 'build_muscle' => 'primary', 'maintain' => 'success'];
?>

<?php if (!empty($plans)): ?>
<div class="row g-4">
    <?php foreach ($plans as $plan): ?>
    <div class="col-xl-4 col-md-6">
        <div class="card card-custom h-100 exercise-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="feature-icon" style="background:rgba(0,200,83,0.15);color:var(--success)"><i class="bi bi-egg-fried"></i></div>
                    <span class="badge bg-<?= $goalColors[$plan->goal] ?? 'secondary' ?>"><?= $goalLabels[$plan->goal] ?? ucfirst($plan->goal) ?></span>
                </div>
                <h5 class="mb-2"><?= htmlspecialchars($plan->name) ?></h5>
                <p class="text-muted mb-3" style="font-size:0.8rem"><?= htmlspecialchars($plan->description ?? '') ?></p>

                <!-- Macro Summary -->
                <div class="d-flex gap-2 mb-3" style="font-size:0.75rem">
                    <span class="badge" style="background:rgba(108,99,255,0.15);color:var(--primary)"><?= number_format($plan->total_calories) ?> kcal</span>
                    <span class="badge" style="background:rgba(108,99,255,0.1);color:var(--primary)">P: <?= $plan->protein_grams ?>g</span>
                    <span class="badge" style="background:rgba(255,193,7,0.1);color:var(--warning)">C: <?= $plan->carbs_grams ?>g</span>
                    <span class="badge" style="background:rgba(239,68,68,0.1);color:var(--danger)">F: <?= $plan->fat_grams ?>g</span>
                </div>

                <p class="text-muted" style="font-size:0.75rem"><i class="bi bi-list-ul me-1"></i><?= count($plan->meals ?? []) ?> bữa ăn</p>
            </div>
            <div class="card-footer" style="background:transparent;border-top:1px solid var(--border-color);padding:12px 20px">
                <div class="d-flex gap-2">
                    <a href="<?= URL_ROOT ?>/diet/show/<?= $plan->id ?>" class="btn btn-sm btn-outline-primary flex-fill"><i class="bi bi-eye me-1"></i>Xem chi tiết</a>
                    <?php if (Session::userRole() === 'admin'): ?>
                    <a href="<?= URL_ROOT ?>/diet/delete/<?= $plan->id ?>" class="btn btn-sm btn-outline-danger" data-confirm="Xóa kế hoạch này?"><i class="bi bi-trash"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="text-center text-muted py-5">
    <i class="bi bi-egg-fried display-4 d-block mb-2"></i>
    Chưa có kế hoạch dinh dưỡng nào
</div>
<?php endif; ?>
