<!-- Body Metrics Tracking -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Theo dõi cơ thể</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Ghi nhận và theo dõi chỉ số bằng biểu đồ</p>
    </div>
    <a href="<?= URL_ROOT ?>/tracking/logs" class="btn btn-outline-primary"><i class="bi bi-journal-text me-2"></i>Nhật ký tập</a>
</div>

<div class="row g-4">
    <!-- Add Metric Form -->
    <div class="col-xl-4">
        <div class="card card-custom">
            <div class="card-header-custom"><h5><i class="bi bi-plus-circle me-2"></i>Ghi chỉ số mới</h5></div>
            <div class="card-body">
                <form action="<?= URL_ROOT ?>/tracking/addMetric" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">

                    <?php if (Session::userRole() !== 'member'): ?>
                    <div class="mb-3">
                        <label class="form-label">Hội viên</label>
                        <select name="member_id" class="form-select" required>
                            <option value="">-- Chọn --</option>
                            <?php foreach ($members as $m): ?>
                                <option value="<?= $m->id ?>"><?= htmlspecialchars($m->full_name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Ngày đo</label>
                        <input type="date" name="measured_date" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label" style="font-size:0.75rem">Cân nặng (kg)</label>
                            <input type="number" step="0.1" name="weight" class="form-control form-control-sm" placeholder="65.5">
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-size:0.75rem">% Mỡ</label>
                            <input type="number" step="0.1" name="body_fat" class="form-control form-control-sm" placeholder="18.5">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label" style="font-size:0.75rem">Cơ bắp (kg)</label>
                            <input type="number" step="0.1" name="muscle_mass" class="form-control form-control-sm" placeholder="30">
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-size:0.75rem">Vòng eo (cm)</label>
                            <input type="number" step="0.1" name="waist" class="form-control form-control-sm" placeholder="75">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="form-label" style="font-size:0.75rem">Ngực (cm)</label>
                            <input type="number" step="0.1" name="chest" class="form-control form-control-sm">
                        </div>
                        <div class="col-4">
                            <label class="form-label" style="font-size:0.75rem">Tay (cm)</label>
                            <input type="number" step="0.1" name="arm" class="form-control form-control-sm">
                        </div>
                        <div class="col-4">
                            <label class="form-label" style="font-size:0.75rem">Đùi (cm)</label>
                            <input type="number" step="0.1" name="thigh" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size:0.75rem">Ghi chú</label>
                        <textarea name="notes" class="form-control form-control-sm" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg me-2"></i>Lưu chỉ số</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Charts & History -->
    <div class="col-xl-8">
        <?php if (!empty($weightData)): ?>
        <!-- Weight Chart -->
        <div class="card card-custom mb-4">
            <div class="card-header-custom"><h5><i class="bi bi-graph-up me-2"></i>Biểu đồ cân nặng</h5></div>
            <div class="card-body"><canvas id="weightChart" height="150"></canvas></div>
        </div>
        <?php endif; ?>

        <!-- Latest Metrics -->
        <?php if ($latest): ?>
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-custom text-center p-3">
                    <div style="font-size:0.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px">Cân nặng</div>
                    <div style="font-size:1.5rem;font-weight:800;color:var(--primary)"><?= $latest->weight ?? '--' ?></div>
                    <div style="font-size:0.7rem;color:var(--text-muted)">kg</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom text-center p-3">
                    <div style="font-size:0.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px">BMI</div>
                    <div style="font-size:1.5rem;font-weight:800;color:var(--info)"><?= $latest->bmi ?? '--' ?></div>
                    <div style="font-size:0.7rem;color:var(--text-muted)">index</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom text-center p-3">
                    <div style="font-size:0.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px">% Mỡ</div>
                    <div style="font-size:1.5rem;font-weight:800;color:var(--warning)"><?= $latest->body_fat ?? '--' ?></div>
                    <div style="font-size:0.7rem;color:var(--text-muted)">%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom text-center p-3">
                    <div style="font-size:0.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px">Cơ bắp</div>
                    <div style="font-size:1.5rem;font-weight:800;color:var(--success)"><?= $latest->muscle_mass ?? '--' ?></div>
                    <div style="font-size:0.7rem;color:var(--text-muted)">kg</div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- History -->
        <div class="card card-custom">
            <div class="card-header-custom"><h5><i class="bi bi-clock-history me-2"></i>Lịch sử đo</h5></div>
            <?php if (!empty($metrics)): ?>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead><tr>
                        <?php if (Session::userRole() !== 'member'): ?><th>Hội viên</th><?php endif; ?>
                        <th>Ngày</th><th>Cân (kg)</th><th>BMI</th><th>% Mỡ</th><th>Cơ bắp</th><th>Eo</th>
                    </tr></thead>
                    <tbody>
                    <?php foreach ($metrics as $m): ?>
                        <tr>
                            <?php if (Session::userRole() !== 'member'): ?><td><?= htmlspecialchars($m->full_name ?? '') ?></td><?php endif; ?>
                            <td><?= date('d/m/Y', strtotime($m->measured_date)) ?></td>
                            <td><strong><?= $m->weight ?? '--' ?></strong></td>
                            <td><?= $m->bmi ?? '--' ?></td>
                            <td><?= $m->body_fat ?? '--' ?>%</td>
                            <td><?= $m->muscle_mass ?? '--' ?></td>
                            <td><?= $m->waist ?? '--' ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="card-body text-center text-muted py-4">Chưa có dữ liệu</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
<?php if (!empty($weightData)): ?>
new Chart(document.getElementById('weightChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode(array_map(fn($d) => date('d/m', strtotime($d->measured_date)), $weightData)) ?>,
        datasets: [{
            label: 'Cân nặng (kg)',
            data: <?= json_encode(array_map(fn($d) => $d->value, $weightData)) ?>,
            borderColor: 'rgba(108,99,255,1)',
            backgroundColor: 'rgba(108,99,255,0.1)',
            fill: true, tension: 0.4, pointRadius: 5, pointHoverRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { labels: { color: '#94a3b8' } } },
        scales: {
            x: { ticks: { color: '#94a3b8' }, grid: { display: false } },
            y: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.05)' } }
        }
    }
});
<?php endif; ?>
</script>
