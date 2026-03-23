<!-- Diet Plan Detail -->
<?php
    $goalLabels = ['lose_fat' => 'Giảm mỡ', 'gain_weight' => 'Tăng cân', 'build_muscle' => 'Tăng cơ', 'maintain' => 'Duy trì'];
    $goalColors = ['lose_fat' => 'danger', 'gain_weight' => 'warning', 'build_muscle' => 'primary', 'maintain' => 'success'];
    $mealIcons  = ['Bữa sáng' => 'bi-sunrise', 'Bữa phụ sáng' => 'bi-cup-hot', 'Bữa trưa' => 'bi-sun', 'Bữa phụ chiều' => 'bi-cookie', 'Bữa tối' => 'bi-moon', 'Bữa phụ tối' => 'bi-moon-stars'];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><?= htmlspecialchars($plan->name) ?></h4>
        <p class="text-muted mb-0" style="font-size:0.85rem"><?= htmlspecialchars($plan->description ?? '') ?></p>
    </div>
    <a href="<?= URL_ROOT ?>/diet" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
</div>

<!-- Macro Overview -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="result-metric-card" style="border-top:3px solid var(--primary)">
            <div class="metric-label">Tổng Calories</div>
            <div class="metric-value" style="color:var(--primary);font-size:2rem"><?= number_format($plan->total_calories) ?></div>
            <div class="metric-desc">kcal / ngày</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="result-metric-card" style="border-top:3px solid var(--info)">
            <div class="metric-label">Protein</div>
            <div class="metric-value" style="color:var(--info);font-size:2rem"><?= $plan->protein_grams ?></div>
            <div class="metric-desc">grams (<?= $plan->total_calories > 0 ? round($plan->protein_grams * 4 / $plan->total_calories * 100) : 0 ?>%)</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="result-metric-card" style="border-top:3px solid var(--warning)">
            <div class="metric-label">Carbs</div>
            <div class="metric-value" style="color:var(--warning);font-size:2rem"><?= $plan->carbs_grams ?></div>
            <div class="metric-desc">grams (<?= $plan->total_calories > 0 ? round($plan->carbs_grams * 4 / $plan->total_calories * 100) : 0 ?>%)</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="result-metric-card" style="border-top:3px solid var(--danger)">
            <div class="metric-label">Fat</div>
            <div class="metric-value" style="color:var(--danger);font-size:2rem"><?= $plan->fat_grams ?></div>
            <div class="metric-desc">grams (<?= $plan->total_calories > 0 ? round($plan->fat_grams * 9 / $plan->total_calories * 100) : 0 ?>%)</div>
        </div>
    </div>
</div>

<!-- Goal Badge -->
<div class="mb-4">
    <span class="badge bg-<?= $goalColors[$plan->goal] ?? 'secondary' ?>" style="font-size:0.85rem;padding:8px 16px">
        <i class="bi bi-bullseye me-1"></i><?= $goalLabels[$plan->goal] ?? ucfirst($plan->goal) ?>
    </span>
</div>

<!-- Meals -->
<h5 class="mb-3"><i class="bi bi-list-ul me-2"></i>Bữa ăn trong ngày</h5>

<?php if (!empty($plan->meals)): ?>
    <?php foreach ($plan->meals as $meal): ?>
    <div class="card card-custom mb-3">
        <div class="card-header-custom" style="background:rgba(0,200,83,0.04)">
            <h5 class="mb-0">
                <i class="bi <?= $mealIcons[$meal->meal_name] ?? 'bi-circle' ?> me-2" style="color:var(--success)"></i>
                <?= htmlspecialchars($meal->meal_name) ?>
            </h5>
            <span style="font-size:0.8rem;color:var(--text-muted)"><?= $meal->calories ?> kcal</span>
        </div>
        <div class="card-body">
            <p class="mb-3" style="font-size:0.9rem"><?= nl2br(htmlspecialchars($meal->food_items)) ?></p>
            <div class="d-flex gap-3" style="font-size:0.8rem">
                <span><i class="bi bi-circle-fill" style="font-size:0.4rem;color:var(--primary)"></i> Protein: <strong><?= $meal->protein ?>g</strong></span>
                <span><i class="bi bi-circle-fill" style="font-size:0.4rem;color:var(--warning)"></i> Carbs: <strong><?= $meal->carbs ?>g</strong></span>
                <span><i class="bi bi-circle-fill" style="font-size:0.4rem;color:var(--danger)"></i> Fat: <strong><?= $meal->fat ?>g</strong></span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="text-center text-muted py-4">Chưa có bữa ăn nào</div>
<?php endif; ?>

<style>
.result-metric-card { background:var(--bg-card); border:1px solid var(--border-color); border-radius:var(--radius); padding:20px; text-align:center; }
.metric-label { font-size:0.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; }
.metric-value { font-weight:800; line-height:1; margin-bottom:6px; }
.metric-desc { font-size:0.8rem; color:var(--text-secondary); }
</style>
