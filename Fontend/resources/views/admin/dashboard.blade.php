@extends('layouts.admin')

@section('title', 'Tổng Quan Hệ Thống')

@section('content')
<div class="container-fluid p-0">
    <!-- Tiêu đề -->
    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in">
        <div>
            <h2 class="fw-bold mb-1">Dashboard</h2>
            <p class="text-muted mb-0">Theo dõi hoạt động kinh doanh và trạng thái AI hôm nay.</p>
        </div>
        <div>
            <button class="btn btn-primary" onclick="alert('Đang trích xuất báo cáo ra file Excel...')" style="background: var(--primary-color); border: none; border-radius: 10px; padding: 10px 20px;">
                <i class="bi bi-cloud-download me-2"></i> Xuất Báo Cáo
            </button>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row g-4 mb-4">
        <!-- Card 1 -->
        <div class="col-12 col-md-6 col-xl-3 animate-fade-in" style="animation-delay: 0.1s;">
            <div class="glass-card h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-1" style="letter-spacing: 1px; font-size: 0.8rem;">Tổng Hội Viên Active</h6>
                        <h3 class="fw-bold mb-0">{{ number_format($kpi['total_members'] ?? 1254) }}</h3>
                    </div>
                    <div class="p-3 rounded-3" style="background: rgba(255,94,0,0.15); color: var(--primary-color);">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                </div>
                <div class="text-success small fw-bold">
                    <i class="bi bi-arrow-up-right"></i> +12.5% <span class="text-muted fw-normal">so với tháng trước</span>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-12 col-md-6 col-xl-3 animate-fade-in" style="animation-delay: 0.2s;">
            <div class="glass-card h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-1" style="letter-spacing: 1px; font-size: 0.8rem;">Doanh Thu (Tháng)</h6>
                        <h3 class="fw-bold mb-0">{{ number_format($kpi['monthly_revenue'] ?? 0) }} đ</h3>
                    </div>
                    <div class="p-3 rounded-3" style="background: rgba(40,167,69,0.15); color: #28a745;">
                        <i class="bi bi-currency-dollar fs-4"></i>
                    </div>
                </div>
                <div class="text-success small fw-bold">
                    <i class="bi bi-arrow-up-right"></i> +8.2% <span class="text-muted fw-normal">so với tháng trước</span>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-12 col-md-6 col-xl-3 animate-fade-in" style="animation-delay: 0.3s;">
            <div class="glass-card h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-1" style="letter-spacing: 1px; font-size: 0.8rem;">Lớp Học Hôm Nay</h6>
                        <h3 class="fw-bold mb-0">{{ $kpi['today_classes'] ?? 24 }}</h3>
                    </div>
                    <div class="p-3 rounded-3" style="background: rgba(23,162,184,0.15); color: #17a2b8;">
                        <i class="bi bi-calendar-event fs-4"></i>
                    </div>
                </div>
                <div class="text-warning small fw-bold">
                    <i class="bi bi-exclamation-circle"></i> 5 lớp <span class="text-muted fw-normal">đã kín chỗ (có Waitlist)</span>
                </div>
            </div>
        </div>

        <!-- Card 4 (AI Specific) -->
        <div class="col-12 col-md-6 col-xl-3 animate-fade-in" style="animation-delay: 0.4s;">
            <div class="glass-card h-100" style="border-color: rgba(255,51,102,0.3); background: linear-gradient(145deg, var(--card-bg) 0%, rgba(255,51,102,0.05) 100%);">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h6 class="text-danger text-uppercase fw-bold mb-1" style="letter-spacing: 1px; font-size: 0.8rem;">Medical Alerts (DLQ)</h6>
                        <h3 class="fw-bold text-danger mb-0">{{ $kpi['medical_alerts'] ?? 3 }}</h3>
                    </div>
                    <div class="p-3 rounded-3" style="background: rgba(255,51,102,0.15); color: #FF3366;">
                        <i class="bi bi-heart-pulse-fill fs-4 animate-pulse"></i>
                    </div>
                </div>
                <div class="text-danger small fw-bold">
                    Cần xử lý khẩn cấp!
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Tables -->
    <div class="row g-4 mb-4">
        <!-- Main Chart -->
        <div class="col-12 col-xl-8 animate-fade-in" style="animation-delay: 0.5s;">
            <div class="glass-card h-100">
                <h5 class="fw-bold mb-4">Tăng Trưởng Doanh Thu & Booking</h5>
                <div style="height: 300px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- AI Medical Alerts Table -->
        <div class="col-12 col-xl-4 animate-fade-in" style="animation-delay: 0.6s;">
            <div class="glass-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Cảnh Báo Y Tế (AI)</h5>
                    <a href="#" class="text-primary text-decoration-none small" style="color: var(--primary-color) !important;">Xem tất cả</a>
                </div>
                
                <div class="alert-list">
                    @forelse($recent_alerts ?? [
                        ['member' => 'Trần Văn A', 'issue' => 'Nhịp tim > 185 bpm', 'time' => '5 phút trước', 'status' => 'critical'],
                        ['member' => 'Lê Thị B', 'issue' => 'SpO2 < 92%', 'time' => '12 phút trước', 'status' => 'critical'],
                        ['member' => 'Nguyễn Văn C', 'issue' => 'Sai tư thế nghiêm trọng (Squat)', 'time' => '1 giờ trước', 'status' => 'warning'],
                    ] as $alert)
                        <div class="d-flex align-items-center p-3 mb-2 rounded-3" style="background: rgba(0,0,0,0.2); border-left: 4px solid {{ $alert['status'] == 'critical' ? '#FF3366' : '#FFC107' }};">
                            <div class="ms-2 flex-grow-1">
                                <div class="fw-bold">{{ $alert['member'] }}</div>
                                <div class="small text-muted">{{ $alert['issue'] }}</div>
                            </div>
                            <div class="small text-muted">{{ $alert['time'] }}</div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">Không có cảnh báo nào.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Khởi tạo Chart.js
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Gradient cho cột
    let gradientOrange = ctx.createLinearGradient(0, 0, 0, 400);
    gradientOrange.addColorStop(0, 'rgba(255, 94, 0, 0.8)');
    gradientOrange.addColorStop(1, 'rgba(255, 94, 0, 0.2)');

    let gradientPurple = ctx.createLinearGradient(0, 0, 0, 400);
    gradientPurple.addColorStop(0, 'rgba(138, 43, 226, 0.8)');
    gradientPurple.addColorStop(1, 'rgba(138, 43, 226, 0.2)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            datasets: [
                {
                    label: 'Doanh thu ($)',
                    data: [32000, 35000, 31000, 42000, 45200, 41000, 48000],
                    backgroundColor: gradientOrange,
                    borderRadius: 8,
                    barPercentage: 0.6
                },
                {
                    label: 'Booking Mới',
                    type: 'line',
                    data: [150, 180, 160, 220, 250, 210, 280],
                    borderColor: '#8A2BE2',
                    backgroundColor: 'transparent',
                    borderWidth: 3,
                    tension: 0.4,
                    pointBackgroundColor: '#8A2BE2',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: { color: '#A0A0B0', font: { family: 'Outfit' } }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { color: '#A0A0B0' }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#A0A0B0' }
                }
            }
        }
    });
</script>
<style>
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    .animate-pulse {
        animation: pulse 1.5s infinite;
    }
</style>
@endpush
