<!-- Reports & Statistics -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="bi bi-bar-chart-line me-2"></i>Báo cáo & Thống kê</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Tổng hợp dữ liệu hoạt động phòng gym</p>
    </div>
</div>

<!-- Summary Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-custom stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(108,99,255,0.15)"><i class="bi bi-people-fill" style="color:var(--primary)"></i></div>
                <div><div class="stat-number"><?= $totalMembers ?></div><div class="stat-label">HV hoạt động</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(239,68,68,0.15)"><i class="bi bi-person-x" style="color:var(--danger)"></i></div>
                <div><div class="stat-number"><?= $totalInactive ?></div><div class="stat-label">Không hoạt động</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(0,200,83,0.15)"><i class="bi bi-cash-stack" style="color:var(--success)"></i></div>
                <div><div class="stat-number"><?= number_format($totalRevenue) ?></div><div class="stat-label">Doanh thu (VNĐ)</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(56,189,248,0.15)"><i class="bi bi-box-arrow-in-right" style="color:var(--info)"></i></div>
                <div><div class="stat-number"><?= $todayCheckins ?></div><div class="stat-label">Check-in hôm nay</div></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Revenue Chart -->
    <div class="col-lg-6">
        <div class="card card-custom h-100">
            <div class="card-header-custom"><h5><i class="bi bi-graph-up me-2"></i>Doanh thu 6 tháng</h5></div>
            <div class="card-body"><canvas id="revenueChart" height="200"></canvas></div>
        </div>
    </div>
    <!-- Members Chart -->
    <div class="col-lg-6">
        <div class="card card-custom h-100">
            <div class="card-header-custom"><h5><i class="bi bi-person-plus me-2"></i>Hội viên mới/tháng</h5></div>
            <div class="card-body"><canvas id="membersChart" height="200"></canvas></div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Weekly Checkins -->
    <div class="col-lg-6">
        <div class="card card-custom h-100">
            <div class="card-header-custom"><h5><i class="bi bi-calendar-week me-2"></i>Check-in 7 ngày</h5></div>
            <div class="card-body"><canvas id="checkinChart" height="200"></canvas></div>
        </div>
    </div>
    <!-- Expiring Soon -->
    <div class="col-lg-6">
        <div class="card card-custom h-100">
            <div class="card-header-custom"><h5><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Gói sắp hết hạn (7 ngày)</h5></div>
            <?php if (!empty($expiringSoon)): ?>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead><tr><th>Hội viên</th><th>Gói</th><th>Hết hạn</th></tr></thead>
                    <tbody>
                    <?php foreach ($expiringSoon as $ep): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($ep->full_name) ?></strong></td>
                            <td><?= htmlspecialchars($ep->package_name) ?></td>
                            <td><span class="text-warning fw-bold"><?= date('d/m/Y', strtotime($ep->end_date)) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="card-body text-center text-muted py-4">Không có gói nào sắp hết hạn</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Revenue Chart
new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_map(fn($r) => $r->month, $revenueByMonth)) ?>,
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: <?= json_encode(array_map(fn($r) => $r->total, $revenueByMonth)) ?>,
            backgroundColor: 'rgba(108,99,255,0.7)',
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { color: '#94a3b8' }, grid: { display: false } },
            y: { ticks: { color: '#94a3b8', callback: v => v.toLocaleString() }, grid: { color: 'rgba(255,255,255,0.05)' } }
        }
    }
});

// Members Chart
new Chart(document.getElementById('membersChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode(array_map(fn($m) => $m->month, $membersByMonth)) ?>,
        datasets: [{
            label: 'Hội viên mới',
            data: <?= json_encode(array_map(fn($m) => $m->total, $membersByMonth)) ?>,
            borderColor: 'rgba(0,200,83,1)',
            backgroundColor: 'rgba(0,200,83,0.1)',
            fill: true, tension: 0.4, pointRadius: 5,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { color: '#94a3b8' }, grid: { display: false } },
            y: { ticks: { color: '#94a3b8', stepSize: 1 }, grid: { color: 'rgba(255,255,255,0.05)' } }
        }
    }
});

// Weekly Checkins
new Chart(document.getElementById('checkinChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_map(fn($d) => $d->day_label, $weeklyCheckins)) ?>,
        datasets: [{
            label: 'Check-ins',
            data: <?= json_encode(array_map(fn($d) => $d->total, $weeklyCheckins)) ?>,
            backgroundColor: 'rgba(56,189,248,0.7)',
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { color: '#94a3b8' }, grid: { display: false } },
            y: { ticks: { color: '#94a3b8', stepSize: 1 }, grid: { color: 'rgba(255,255,255,0.05)' } }
        }
    }
});
</script>
