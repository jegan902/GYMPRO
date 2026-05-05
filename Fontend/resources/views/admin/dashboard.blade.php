@extends('layouts.admin')

@section('title', 'Tổng Quan Hệ Thống')

@push('styles')
<style>
    :root {
        --dash-bg: #f8f9fa;
        --card-bg: #ffffff;
        --orange-main: #FF5E00;
        --text-main: #1a1d23;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
    }

    .dashboard-wrapper {
        background-color: var(--dash-bg);
        min-height: 100vh;
        padding: 24px;
        color: var(--text-main);
        font-family: 'Inter', sans-serif;
    }

    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05);
        border-color: var(--orange-main);
        transform: translateY(-5px);
    }

    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .icon-orange { background: #fff7ed; color: var(--orange-main); }
    .icon-green { background: #f0fdf4; color: #16a34a; }
    .icon-blue { background: #f0f9ff; color: #0284c7; }
    .icon-red { background: #fef2f2; color: #dc2626; }

    .chart-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    }

    .alert-item {
        display: flex;
        align-items: center;
        padding: 14px;
        background: #f8f9fa;
        border-radius: 18px;
        margin-bottom: 10px;
        border: 1px solid transparent;
        transition: all 0.3s;
    }

    .alert-item:hover {
        border-color: var(--orange-main);
        background: #ffffff;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        transform: translateX(5px);
    }

    .export-btn {
        background: var(--orange-main);
        color: #fff;
        border: none;
        padding: 10px 24px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s;
        box-shadow: 0 10px 15px rgba(255, 94, 0, 0.2);
    }

    .export-btn:hover {
        background: #ea580c;
        transform: translateY(-2px);
        box-shadow: 0 15px 20px rgba(255, 94, 0, 0.3);
    }

    .badge-soft {
        background: #f0fdf4;
        color: #16a34a;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
    }
    
    .text-dim { color: var(--text-muted); }
</style>
@endpush

@section('content')
<div class="dashboard-wrapper">
    <div class="container-fluid p-0">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Dashboard</h5>
                <p class="text-dim small mb-0">Hệ thống đang hoạt động ổn định.</p>
            </div>
            <button class="export-btn">
                <i class="bi bi-arrow-down-short fs-5"></i> Xuất Báo Cáo
            </button>
        </div>

        <!-- KPI Grid -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box icon-orange"><i class="bi bi-people-fill"></i></div>
                        <span class="badge-soft">+12%</span>
                    </div>
                    <div class="text-dim fw-bold mb-1 text-uppercase" style="letter-spacing: 0.5px; font-size: 0.65rem;">Tổng Hội Viên</div>
                    <div class="h4 fw-bold mb-0 text-main">{{ number_format($kpi['total_members'] ?? 1254) }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box icon-green"><i class="bi bi-wallet2"></i></div>
                        <span class="badge-soft">+8.2%</span>
                    </div>
                    <div class="text-dim fw-bold mb-1 text-uppercase" style="letter-spacing: 0.5px; font-size: 0.65rem;">Doanh Thu</div>
                    <div class="h4 fw-bold mb-0 text-main">{{ number_format($kpi['monthly_revenue'] ?? 45000000) }} đ</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box icon-blue"><i class="bi bi-calendar-check"></i></div>
                        <span class="text-dim small" style="font-size: 0.65rem;">80% Full</span>
                    </div>
                    <div class="text-dim fw-bold mb-1 text-uppercase" style="letter-spacing: 0.5px; font-size: 0.65rem;">Lớp Học</div>
                    <div class="h4 fw-bold mb-0 text-main">{{ $kpi['today_classes'] ?? 24 }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box icon-red"><i class="bi bi-heart-pulse-fill"></i></div>
                        <span class="badge bg-danger rounded-pill" style="font-size: 0.6rem; padding: 2px 6px;">3 KHẨN CẤP</span>
                    </div>
                    <div class="text-dim fw-bold mb-1 text-uppercase" style="letter-spacing: 0.5px; font-size: 0.65rem;">Cảnh Báo AI</div>
                    <div class="h4 fw-bold mb-0 text-danger">{{ $kpi['medical_alerts'] ?? 3 }}</div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="chart-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0 text-uppercase" style="letter-spacing: 0.5px; font-size: 0.8rem;">Hiệu Suất Kinh Doanh</h6>
                        <select class="form-select form-select-sm w-auto border-0 bg-light text-dim" style="font-size: 0.75rem;">
                            <option>Tháng này</option>
                        </select>
                    </div>
                    <div style="height: 300px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="chart-card">
                    <h6 class="fw-bold mb-4 text-uppercase" style="letter-spacing: 0.5px; font-size: 0.8rem;">Cảnh Báo AI</h6>
                    <div class="alert-list">
                        @forelse($recent_alerts ?? [
                            ['member' => 'Trần Văn A', 'issue' => 'Nhịp tim cao', 'time' => '5p', 'level' => 'critical'],
                            ['member' => 'Lê Thị B', 'issue' => 'SpO2 thấp', 'time' => '15p', 'level' => 'critical'],
                            ['member' => 'Nguyễn C', 'issue' => 'Sai tư thế', 'time' => '1h', 'level' => 'warning']
                        ] as $alert)
                            <div class="alert-item">
                                <div class="icon-box icon-red me-3" style="min-width: 38px; height: 38px; font-size: 1rem;">
                                    <i class="bi {{ ($alert['level'] ?? '') == 'critical' ? 'bi-activity' : 'bi-info-circle' }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold small">{{ $alert['member'] }}</div>
                                    <div class="text-dim" style="font-size: 0.75rem;">{{ $alert['issue'] }}</div>
                                </div>
                                <div class="text-end text-dim" style="font-size: 0.7rem;">{{ $alert['time'] }}</div>
                            </div>
                        @empty
                            <p class="text-center text-dim py-5 small">Không có cảnh báo mới</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // Gradient cho đường biểu đồ
        let gradOrange = ctx.createLinearGradient(0, 0, 0, 300);
        gradOrange.addColorStop(0, 'rgba(255, 94, 0, 0.1)');
        gradOrange.addColorStop(1, 'rgba(255, 94, 0, 0)');
    
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'CN'],
                datasets: [
                    {
                        label: 'Doanh Thu ($)',
                        data: [3200, 3500, 3100, 4200, 4520, 4100, 4800],
                        borderColor: '#FF5E00',
                        backgroundColor: gradOrange,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#FF5E00',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9', borderDash: [5, 5] },
                        ticks: { color: '#94a3b8', font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8', font: { size: 11 } }
                    }
                }
            }
        });
    });
</script>
@endpush
