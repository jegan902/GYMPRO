<!-- Exercise Logs -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Nhật ký tập luyện</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Ghi nhận bài tập hàng ngày</p>
    </div>
    <a href="<?= URL_ROOT ?>/tracking" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Chỉ số cơ thể</a>
</div>

<div class="row g-4">
    <!-- Add Log Form -->
    <div class="col-xl-4">
        <div class="card card-custom">
            <div class="card-header-custom"><h5><i class="bi bi-plus-circle me-2"></i>Ghi bài tập</h5></div>
            <div class="card-body">
                <form action="<?= URL_ROOT ?>/tracking/addLog" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">

                    <?php if (Session::userRole() !== 'member'): ?>
                    <div class="mb-3">
                        <label class="form-label">Hội viên</label>
                        <select name="member_id" class="form-select" required>
                            <option value="">-- Chọn --</option>
                            <?php foreach ($members as $m): ?>
                                <option value="<?= $m->id ?>" <?= ($member && $member->id == $m->id) ? 'selected' : '' ?>><?= htmlspecialchars($m->full_name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Bài tập</label>
                        <select name="exercise_id" class="form-select" required>
                            <option value="">-- Chọn --</option>
                            <?php foreach ($exercises as $ex): ?>
                                <option value="<?= $ex->id ?>"><?= htmlspecialchars($ex->name) ?> (<?= $ex->muscle_group_vi ?? $ex->muscle_group_name ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngày</label>
                        <input type="date" name="log_date" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="form-label" style="font-size:0.75rem">Số sets</label>
                            <input type="number" name="total_sets" class="form-control form-control-sm" value="3" min="1" max="10">
                        </div>
                        <div class="col-4">
                            <label class="form-label" style="font-size:0.75rem">Reps/set</label>
                            <input type="number" name="reps" class="form-control form-control-sm" value="10">
                        </div>
                        <div class="col-4">
                            <label class="form-label" style="font-size:0.75rem">Kg/set</label>
                            <input type="number" step="0.5" name="weight_used" class="form-control form-control-sm" placeholder="20">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size:0.75rem">Ghi chú</label>
                        <textarea name="notes" class="form-control form-control-sm" rows="2" placeholder="Cảm nhận, ghi chú..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg me-2"></i>Ghi nhận</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Logs History -->
    <div class="col-xl-8">
        <?php if (!empty($groupedLogs)): ?>
            <?php foreach ($groupedLogs as $date => $logs): ?>
            <div class="card card-custom mb-3">
                <div class="card-header-custom" style="background:rgba(108,99,255,0.04)">
                    <h5 class="mb-0"><i class="bi bi-calendar-date me-2"></i><?= date('d/m/Y (l)', strtotime($date)) ?></h5>
                    <span class="badge bg-secondary"><?= count($logs) ?> sets</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead><tr><th>Bài tập</th><th>Nhóm cơ</th><th>Set</th><th>Reps</th><th>Kg</th></tr></thead>
                        <tbody>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($log->exercise_name) ?></strong></td>
                                <td><span class="badge bg-primary" style="font-size:0.65rem"><?= htmlspecialchars($log->muscle_group ?? '') ?></span></td>
                                <td>Set <?= $log->set_number ?></td>
                                <td><?= $log->reps ?></td>
                                <td><?= $log->weight ?> kg</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="card card-custom">
                <div class="card-body text-center text-muted py-5">
                    <i class="bi bi-journal-text display-4 d-block mb-2"></i>
                    <?php if (Session::userRole() !== 'member' && !$member): ?>
                        Vui lòng chọn hội viên để xem nhật ký tập
                    <?php else: ?>
                        Chưa có nhật ký tập luyện
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
