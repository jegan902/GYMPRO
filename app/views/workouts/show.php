<!-- Workout Plan Detail -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><?= htmlspecialchars($plan->name) ?></h4>
        <p class="text-muted mb-0" style="font-size:0.85rem"><?= htmlspecialchars($plan->description ?? '') ?></p>
    </div>
    <a href="<?= URL_ROOT ?>/workout" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
</div>

<!-- Plan Info -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="result-metric-card">
            <div class="metric-label">Độ khó</div>
            <div class="metric-desc"><span class="badge bg-<?= $plan->level === 'beginner' ? 'success' : ($plan->level === 'advanced' ? 'danger' : 'warning') ?>" style="font-size:0.85rem"><?= ucfirst($plan->level ?? 'beginner') ?></span></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="result-metric-card">
            <div class="metric-label">Mục tiêu</div>
            <div class="metric-desc" style="font-size:0.9rem;font-weight:600"><?= htmlspecialchars(ucfirst($plan->goal ?? 'General')) ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="result-metric-card">
            <div class="metric-label">Ngày/tuần</div>
            <div class="metric-desc" style="font-size:0.9rem;font-weight:600"><?= $plan->days_per_week ?? 3 ?> ngày</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="result-metric-card">
            <div class="metric-label">Số buổi tập</div>
            <div class="metric-desc" style="font-size:0.9rem;font-weight:600"><?= count($plan->sessions ?? []) ?> buổi</div>
        </div>
    </div>
</div>

<!-- Sessions -->
<?php if (!$hasPT): ?>
    <div class="alert alert-warning text-center p-5 mt-4">
        <i class="bi bi-lock-fill display-1 text-muted d-block mb-3"></i>
        <h4 style="color:var(--text)">Giáo án dành riêng cho gói PT</h4>
        <p class="text-muted">Bạn cần nâng cấp lên gói tập có Huấn luyện viên cá nhân (PT) để xem chi tiết giáo án này.</p>
        <a href="<?= URL_ROOT ?>/package" class="btn btn-primary mt-3">Xem thẻ tập</a>
    </div>
<?php else: ?>
    <?php if (!empty($plan->sessions)): ?>
        <?php foreach ($plan->sessions as $session): ?>
        <div class="card card-custom mb-3">
            <div class="card-header-custom" style="background:rgba(108,99,255,0.06)">
                <h5 class="mb-0">
                    <i class="bi bi-calendar-day me-2"></i>Ngày <?= $session->day_number ?> – <?= htmlspecialchars($session->session_name) ?>
                    <?php if (!empty($session->focus_area)): ?>
                        <span class="text-muted" style="font-size:0.8rem;font-weight:400"> | <?= htmlspecialchars($session->focus_area) ?></span>
                    <?php endif; ?>
                </h5>
                <span class="badge bg-secondary"><?= count($session->exercises ?? []) ?> bài tập</span>
            </div>
            <?php if (!empty($session->exercises)): ?>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th style="width:40px">#</th>
                            <th>Bài tập</th>
                            <th>Nhóm cơ</th>
                            <th>Sets</th>
                            <th>Reps</th>
                            <th>Rest</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($session->exercises as $i => $ex): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><strong><?= htmlspecialchars($ex->exercise_name) ?></strong></td>
                            <td><span class="badge bg-primary" style="font-size:0.7rem"><?= htmlspecialchars($ex->muscle_group ?? '-') ?></span></td>
                            <td><?= $ex->sets ?></td>
                            <td><?= htmlspecialchars($ex->reps) ?></td>
                            <td><?= $ex->rest_seconds ?>s</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="card-body text-center text-muted">Chưa có bài tập</div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center text-muted py-4">Chưa có buổi tập nào trong giáo án</div>
    <?php endif; ?>
<?php endif; ?>

<style>
.result-metric-card { background:var(--bg-card); border:1px solid var(--border-color); border-radius:var(--radius); padding:16px; text-align:center; }
.metric-label { font-size:0.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; }
.metric-desc { font-size:0.8rem; color:var(--text-secondary); }
</style>
