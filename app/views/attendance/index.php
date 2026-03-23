<!-- Check-in Dashboard -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Check-in</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Quản lý điểm danh hội viên hôm nay</p>
    </div>
    <a href="<?= URL_ROOT ?>/attendance/history" class="btn btn-outline-primary"><i class="bi bi-clock-history me-2"></i>Lịch sử</a>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-custom stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(108,99,255,0.15)"><i class="bi bi-box-arrow-in-right" style="color:var(--primary)"></i></div>
                <div><div class="stat-number"><?= $totalToday ?></div><div class="stat-label">Check-in hôm nay</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(0,200,83,0.15)"><i class="bi bi-person-check" style="color:var(--success)"></i></div>
                <div><div class="stat-number"><?= $currentlyIn ?></div><div class="stat-label">Đang trong phòng</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(255,193,7,0.15)"><i class="bi bi-graph-up" style="color:var(--warning)"></i></div>
                <div><div class="stat-number" id="weeklyAvg">--</div><div class="stat-label">TB tuần qua</div></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Check-in Form -->
    <?php if (in_array(Session::userRole(), ['admin', 'staff'])): ?>
    <div class="col-xl-4">
        <div class="card card-custom">
            <div class="card-header-custom"><h5><i class="bi bi-qr-code me-2"></i>Check-in nhanh</h5></div>
            <div class="card-body">
                <form action="<?= URL_ROOT ?>/attendance/checkin" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
                    <input type="hidden" name="method" value="manual">
                    <div class="mb-3">
                        <label class="form-label">Chọn hội viên</label>
                        <select name="member_id" class="form-select" required id="memberSelect">
                            <option value="">-- Tìm hội viên --</option>
                            <?php foreach ($members as $m): ?>
                                <option value="<?= $m->id ?>"><?= htmlspecialchars($m->full_name) ?> (<?= $m->phone ?? $m->email ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right me-2"></i>Check-in</button>
                </form>

                <hr style="border-color:var(--border-color)">

                <form action="<?= URL_ROOT ?>/attendance/checkout" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
                    <div class="mb-3">
                        <label class="form-label">Check-out hội viên</label>
                        <select name="member_id" class="form-select" required>
                            <option value="">-- Chọn --</option>
                            <?php foreach ($todayList as $a): ?>
                                <?php if (empty($a->check_out_time)): ?>
                                <option value="<?= $a->member_id ?>"><?= htmlspecialchars($a->full_name) ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-secondary w-100"><i class="bi bi-box-arrow-right me-2"></i>Check-out</button>
                </form>
            </div>
        </div>

        <!-- Weekly Chart -->
        <div class="card card-custom mt-4">
            <div class="card-header-custom"><h5><i class="bi bi-bar-chart me-2"></i>Check-in 7 ngày</h5></div>
            <div class="card-body">
                <canvas id="weeklyChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Today's List -->
    <div class="<?= in_array(Session::userRole(), ['admin', 'staff']) ? 'col-xl-8' : 'col-12' ?>">
        <div class="card card-custom">
            <div class="card-header-custom">
                <h5><i class="bi bi-list-check me-2"></i>Danh sách hôm nay</h5>
                <span class="badge bg-primary"><?= count($todayList) ?></span>
            </div>
            <?php if (!empty($todayList)): ?>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead><tr><th>Hội viên</th><th>Check-in</th><th>Check-out</th><th>Thời gian</th><th>Phương thức</th></tr></thead>
                    <tbody>
                    <?php foreach ($todayList as $a): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-sm"><?= strtoupper(substr($a->full_name, 0, 1)) ?></div>
                                    <strong><?= htmlspecialchars($a->full_name) ?></strong>
                                </div>
                            </td>
                            <td><?= date('H:i', strtotime($a->check_in_time)) ?></td>
                            <td>
                                <?php if ($a->check_out_time): ?>
                                    <?= date('H:i', strtotime($a->check_out_time)) ?>
                                <?php else: ?>
                                    <span class="badge bg-success"><i class="bi bi-circle-fill" style="font-size:0.5rem"></i> Đang tập</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($a->check_out_time): ?>
                                    <?php
                                        $diff = strtotime($a->check_out_time) - strtotime($a->check_in_time);
                                        $hours = floor($diff / 3600);
                                        $mins = floor(($diff % 3600) / 60);
                                    ?>
                                    <span class="text-muted"><?= $hours ?>h <?= $mins ?>m</span>
                                <?php else: ?>
                                    <span class="text-muted">--</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge bg-<?= $a->method === 'qr' ? 'info' : 'secondary' ?>"><?= strtoupper($a->method) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="card-body text-center text-muted py-4"><i class="bi bi-emoji-neutral display-6 d-block mb-2"></i>Chưa có ai check-in hôm nay</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.avatar-sm { width:32px; height:32px; border-radius:50%; background:var(--primary); color:#fff; display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:700; }
</style>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
const weeklyData = <?= json_encode($weeklyStats) ?>;
const labels = weeklyData.map(d => {
    const date = new Date(d.date);
    return date.toLocaleDateString('vi-VN', {weekday:'short', day:'numeric'});
});
const values = weeklyData.map(d => d.total);

// Calculate weekly average
const avg = values.length > 0 ? Math.round(values.reduce((a,b) => a+b, 0) / values.length) : 0;
document.getElementById('weeklyAvg').textContent = avg;

if (document.getElementById('weeklyChart')) {
    new Chart(document.getElementById('weeklyChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Check-in',
                data: values,
                backgroundColor: 'rgba(108,99,255,0.6)',
                borderColor: 'rgba(108,99,255,1)',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { color: '#94a3b8' }, grid: { display: false } },
                y: { ticks: { color: '#94a3b8', stepSize: 1 }, grid: { color: 'rgba(255,255,255,0.05)' }, beginAtZero: true }
            }
        }
    });
}
</script>
