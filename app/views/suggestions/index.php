<!-- AI Suggestions Page -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="bi bi-robot me-2"></i>Gợi ý AI thông minh</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Phân tích và đề xuất dựa trên chỉ số cơ thể, mục tiêu, lịch sử tập</p>
    </div>
</div>

<!-- Member Selection (for staff/admin) -->
<?php if (Session::userRole() !== 'member'): ?>
<div class="card card-custom mb-4">
    <div class="card-body py-3">
        <form method="GET" class="d-flex gap-3 align-items-end flex-wrap">
            <div>
                <label class="form-label" style="font-size:0.7rem">Hội viên</label>
                <select name="member_id" class="form-select form-select-sm" style="min-width:200px">
                    <option value="">-- Chọn hội viên --</option>
                    <?php foreach ($members as $m): ?>
                        <option value="<?= $m->id ?>" <?= ($member && $member->id == $m->id) ? 'selected' : '' ?>><?= htmlspecialchars($m->full_name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="form-label" style="font-size:0.7rem">Mục tiêu</label>
                <select name="goal" class="form-select form-select-sm">
                    <option value="maintain" <?= ($_GET['goal'] ?? '') === 'maintain' ? 'selected' : '' ?>>Duy trì</option>
                    <option value="lose_fat" <?= ($_GET['goal'] ?? '') === 'lose_fat' ? 'selected' : '' ?>>Giảm mỡ</option>
                    <option value="build_muscle" <?= ($_GET['goal'] ?? '') === 'build_muscle' ? 'selected' : '' ?>>Tăng cơ</option>
                    <option value="gain_weight" <?= ($_GET['goal'] ?? '') === 'gain_weight' ? 'selected' : '' ?>>Tăng cân</option>
                </select>
            </div>
            <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-cpu me-1"></i>Phân tích</button>
        </form>
    </div>
</div>
<?php endif; ?>

<?php if ($member && !empty($suggestions)): ?>

<!-- Current Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-custom text-center p-3">
            <div style="font-size:0.65rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px">BMI</div>
            <div style="font-size:2rem;font-weight:800;color:var(--primary)"><?= $latest->bmi ?? $member->bmi ?? '--' ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom text-center p-3">
            <div style="font-size:0.65rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px">Cân nặng</div>
            <div style="font-size:2rem;font-weight:800;color:var(--info)"><?= $latest->weight ?? $member->weight ?? '--' ?> <span style="font-size:0.8rem">kg</span></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom text-center p-3">
            <div style="font-size:0.65rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px">% Mỡ</div>
            <div style="font-size:2rem;font-weight:800;color:var(--warning)"><?= $latest->body_fat ?? '--' ?><span style="font-size:0.8rem">%</span></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom text-center p-3">
            <div style="font-size:0.65rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px">Cơ bắp</div>
            <div style="font-size:2rem;font-weight:800;color:var(--success)"><?= $latest->muscle_mass ?? '--' ?> <span style="font-size:0.8rem">kg</span></div>
        </div>
    </div>
</div>

<!-- Suggestions -->
<h5 class="mb-3"><i class="bi bi-lightbulb me-2"></i>Đề xuất cho bạn</h5>
<div class="row g-3 mb-4">
    <?php foreach ($suggestions as $s): ?>
    <div class="col-md-6">
        <div class="card card-custom h-100" style="border-left:4px solid var(--<?= $s['type'] ?>)">
            <div class="card-body">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi <?= $s['icon'] ?>" style="font-size:1.3rem;color:var(--<?= $s['type'] ?>)"></i>
                    <h6 class="mb-0"><?= $s['title'] ?></h6>
                </div>
                <p class="text-muted mb-3" style="font-size:0.85rem"><?= $s['message'] ?></p>
                <ul class="mb-0" style="font-size:0.8rem;padding-left:18px">
                    <?php foreach ($s['actions'] as $a): ?>
                        <li class="mb-1"><?= $a ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Workout Recommendation -->
<?php if ($workoutRec): ?>
<div class="card card-custom" style="border:1px solid rgba(108,99,255,0.3);background:rgba(108,99,255,0.03)">
    <div class="card-body">
        <h5 class="mb-3"><i class="bi bi-calendar-week me-2" style="color:var(--primary)"></i>Giáo án đề xuất</h5>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="text-center">
                    <div style="font-size:0.65rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px">Kiểu tập</div>
                    <div style="font-size:1.2rem;font-weight:700;color:var(--primary)"><?= $workoutRec['style'] ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div style="font-size:0.65rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px">Số buổi/tuần</div>
                    <div style="font-size:1.2rem;font-weight:700;color:var(--success)"><?= $workoutRec['days'] ?> buổi</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div style="font-size:0.65rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px">Focus</div>
                    <div style="font-size:0.85rem;color:var(--text-secondary)"><?= $workoutRec['focus'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php elseif (!$member): ?>
<div class="card card-custom">
    <div class="card-body text-center text-muted py-5">
        <i class="bi bi-robot display-4 d-block mb-2"></i>
        Chọn hội viên để xem gợi ý AI
    </div>
</div>
<?php else: ?>
<div class="card card-custom">
    <div class="card-body text-center text-muted py-5">
        <i class="bi bi-emoji-neutral display-4 d-block mb-2"></i>
        Chưa đủ dữ liệu để phân tích. Vui lòng cập nhật chỉ số cơ thể.
    </div>
</div>
<?php endif; ?>
