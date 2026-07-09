@extends('layouts.admin')

@section('title', 'Tổng Quan Hệ Thống')

@push('styles')
<style>
    :root {
        --primary-orange: #FF5E00;
        --primary-orange-glow: rgba(255, 94, 0, 0.08);
        --panel-bg: #FFFFFF;
        --border-color: #E2E8F0;
        --text-main: #0F172A;
        --text-muted: #64748B;
        --alert-critical-bg: #FEF2F2;
        --alert-critical-border: #FEE2E2;
        --alert-critical-text: #EF4444;
        --alert-warning-bg: #FFFBEB;
        --alert-warning-border: #FEF3C7;
        --alert-warning-text: #D97706;
    }

    .dashboard-wrapper {
        min-height: calc(100vh - 56px);
        color: var(--text-main);
        font-family: 'Outfit', sans-serif;
    }

    /* KPI Cards - Apple Health style */
    .stat-card {
        background: var(--panel-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 24px;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    }

    .stat-card:hover {
        border-color: var(--primary-orange);
        box-shadow: 0 10px 15px -3px rgba(255, 94, 0, 0.06);
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        background: rgba(255, 94, 0, 0.08);
        color: var(--primary-orange);
    }

    .stat-trend {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 2px;
    }

    .trend-up {
        background: #DCFCE7;
        color: #15803D;
    }

    /* Role Quick Actions Hub */
    .role-hub-card {
        background: linear-gradient(135deg, rgba(255, 94, 0, 0.02) 0%, rgba(255, 255, 255, 1) 100%);
        border: 1px solid #FFEDD5;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .role-badge-title {
        background: var(--primary-orange);
        color: white;
        font-size: 0.65rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        padding: 4px 10px;
        border-radius: 2px;
        display: inline-block;
        margin-bottom: 12px;
    }

    .hub-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .hub-btn {
        background: white;
        border: 1px solid var(--border-color);
        padding: 16px;
        border-radius: 6px;
        color: var(--text-main);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 700;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .hub-btn:hover {
        border-color: var(--primary-orange);
        color: var(--primary-orange);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        transform: translateY(-1px);
    }

    .hub-btn i {
        font-size: 1.25rem;
        color: var(--primary-orange);
    }

    /* Main Dashboard Cards */
    .dashboard-card {
        background: var(--panel-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 30px;
        height: 100%;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    }

    .card-title-text {
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--text-main);
        border-left: 3px solid var(--primary-orange);
        padding-left: 10px;
        margin-bottom: 24px;
    }

    /* WOW Body Analytics Section - Light Mode */
    .body-analytics-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        align-items: center;
    }
    @media(max-width: 991px) {
        .body-analytics-grid {
            grid-template-columns: 1fr;
        }
    }

    .silhouette-container {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #F8FAFC;
        border-radius: 6px;
        padding: 30px 10px;
        border: 1px dashed var(--border-color);
        height: 440px;
    }

    /* Glowing Hotspot Pointers */
    .health-pointer {
        position: absolute;
        display: flex;
        align-items: center;
        gap: 8px;
        z-index: 10;
        cursor: pointer;
    }

    .pointer-dot {
        width: 10px;
        height: 10px;
        background: var(--primary-orange);
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(255, 94, 0, 0.4);
        position: relative;
        animation: pulseGlow 2.5s infinite;
    }

    @keyframes pulseGlow {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.5); opacity: 0.6; box-shadow: 0 0 15px rgba(255, 94, 0, 0.6); }
        100% { transform: scale(1); opacity: 1; }
    }

    .pointer-line {
        height: 1px;
        background: linear-gradient(90deg, var(--primary-orange) 0%, transparent 100%);
        width: 30px;
    }

    .pointer-label {
        background: white;
        border: 1px solid var(--border-color);
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 700;
        white-space: nowrap;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        pointer-events: none;
        transition: border-color 0.2s;
    }
    
    .health-pointer:hover .pointer-label {
        border-color: var(--primary-orange);
    }

    /* Hotspot coordinate settings */
    .pointer-posture { top: 70px; left: 15%; flex-direction: row-reverse; }
    .pointer-posture .pointer-line { background: linear-gradient(270deg, var(--primary-orange) 0%, transparent 100%); }

    .pointer-heart { top: 140px; right: 15%; }
    
    .pointer-waist { top: 200px; left: 10%; flex-direction: row-reverse; }
    .pointer-waist .pointer-line { background: linear-gradient(270deg, var(--primary-orange) 0%, transparent 100%); }

    .pointer-muscle { top: 280px; right: 12%; }

    /* HUD style widgets */
    .recovery-hud {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 20px;
    }

    .hud-stat-box {
        background: #F8FAFC;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 16px;
        text-align: center;
    }

    .hud-circle-progress {
        position: relative;
        width: 60px;
        height: 60px;
        margin: 0 auto 10px;
    }
    .hud-circle-progress svg {
        width: 100%;
        height: 100%;
        transform: rotate(-90deg);
    }
    .hud-circle-bg {
        fill: none;
        stroke: #E2E8F0;
        stroke-width: 6;
    }
    .hud-circle-bar {
        fill: none;
        stroke-width: 6;
        stroke-linecap: round;
        stroke-dasharray: 220;
    }

    /* Live alerts list */
    .alert-item {
        display: flex;
        align-items: center;
        padding: 14px 16px;
        border-radius: 6px;
        margin-bottom: 12px;
        border: 1px solid transparent;
        transition: all 0.2s;
    }

    .alert-item:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    }

    .alert-item.alert-critical-style {
        background: var(--alert-critical-bg);
        border-color: var(--alert-critical-border);
        color: var(--alert-critical-text);
    }

    .alert-item.alert-warning-style {
        background: var(--alert-warning-bg);
        border-color: var(--alert-warning-border);
        color: var(--alert-warning-text);
    }

    .alert-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        background: white;
        flex-shrink: 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .table-light-custom {
        width: 100%;
        color: var(--text-main);
        font-size: 0.85rem;
    }
    .table-light-custom td {
        padding: 12px 0;
        border-bottom: 1px solid var(--border-color);
    }
    .table-light-custom tr:last-child td {
        border-bottom: none;
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrapper animate-fade-in">
    <div class="container-fluid p-0">
        <!-- Top Title Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1 text-uppercase letter-spacing-1" style="font-size: 1.25rem;">
                    @if(session('user_role') == 'Super Admin')
                        👑 Bảng Điều Khiển Hệ Thống
                    @elseif(session('user_role') == 'Branch Admin')
                        📍 Quản Lý Chi Nhánh
                    @else
                        💪 Bảng Nghiệp Vụ Huấn Luyện
                    @endif
                </h4>
                <p class="text-muted small mb-0">
                    <i class="bi bi-person-fill text-primary-orange me-1"></i>
                    Tài khoản: <strong>{{ session('user_name') }}</strong> | Vai trò: <span class="badge bg-secondary">{{ session('user_role') }}</span>
                </p>
            </div>
            <div>
                <span class="text-muted small me-2"><i class="bi bi-clock-history"></i> Live Update</span>
            </div>
        </div>

        <!-- Role Quick Actions Hub (Quản lý cực kỳ dễ dàng theo từng Role) -->
        <div class="role-hub-card">
            <span class="role-badge-title">Công cụ cho {{ session('user_role') }}</span>
            <h5 class="fw-bold mb-3" style="font-size: 0.95rem;">Lối Tắt Vận Hành Nhanh</h5>
            <div class="hub-grid">
                @if(session('user_role') == 'Super Admin')
                    <!-- Super Admin Actions -->
                    <a href="{{ route('admin.branches') }}" class="hub-btn">
                        <i class="bi bi-building"></i>
                        <span>Quản lý chi nhánh</span>
                    </a>
                    <a href="{{ route('admin.managers') }}" class="hub-btn">
                        <i class="bi bi-person-badge"></i>
                        <span>Ủy quyền Quản lý</span>
                    </a>
                    <a href="{{ route('admin.packages') }}" class="hub-btn">
                        <i class="bi bi-box-seam"></i>
                        <span>Thiết lập Gói tập</span>
                    </a>
                @elseif(session('user_role') == 'Branch Admin')
                    <!-- Branch Admin Actions -->
                    <a href="{{ route('admin.members') }}" class="hub-btn">
                        <i class="bi bi-people-fill"></i>
                        <span>Hội viên chi nhánh</span>
                    </a>
                    <a href="{{ route('admin.equipments') }}" class="hub-btn">
                        <i class="bi bi-bicycle"></i>
                        <span>Thiết bị tập luyện</span>
                    </a>
                    <a href="{{ route('admin.packages') }}" class="hub-btn">
                        <i class="bi bi-cash-stack"></i>
                        <span>Xem gói & doanh thu</span>
                    </a>
                @else
                    <!-- Staff/PT Actions -->
                    <a href="{{ route('admin.members') }}" class="hub-btn">
                        <i class="bi bi-heart-pulse-fill"></i>
                        <span>Nhập chỉ số thể trạng</span>
                    </a>
                    <a href="{{ route('admin.equipments') }}" class="hub-btn">
                        <i class="bi bi-wrench-adjustable"></i>
                        <span>Báo cáo hỏng hóc</span>
                    </a>
                @endif
                <a href="{{ route('admin.profile') }}" class="hub-btn">
                    <i class="bi bi-person-gear"></i>
                    <span>Hồ sơ cá nhân</span>
                </a>
            </div>
        </div>

        <!-- KPI Grid -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted fw-bold mb-1 text-uppercase" style="letter-spacing: 1px; font-size: 0.65rem;">Tổng Hội Viên</div>
                        <div class="h3 fw-bold mb-2">{{ number_format($kpi['total_members'] ?? 1428) }}</div>
                        <span class="stat-trend trend-up">+14.2%</span>
                    </div>
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted fw-bold mb-1 text-uppercase" style="letter-spacing: 1px; font-size: 0.65rem;">Doanh Thu Tháng</div>
                        <div class="h3 fw-bold mb-2">{{ number_format($kpi['monthly_revenue'] ?? 58450000) }} đ</div>
                        <span class="stat-trend trend-up">+9.5%</span>
                    </div>
                    <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted fw-bold mb-1 text-uppercase" style="letter-spacing: 1px; font-size: 0.65rem;">Lớp Đang Mở</div>
                        <div class="h3 fw-bold mb-2">{{ $kpi['today_classes'] ?? 32 }}</div>
                        <span class="stat-trend trend-up" style="background:#EFF6FF; color:#1D4ED8;">85% Slot</span>
                    </div>
                    <div class="stat-icon"><i class="bi bi-calendar3"></i></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card d-flex justify-content-between align-items-center" style="border-color: #FEE2E2;">
                    <div>
                        <div class="text-muted fw-bold mb-1 text-uppercase" style="letter-spacing: 1px; font-size: 0.65rem; color:#EF4444;">AI Health Alerts</div>
                        <div class="h3 fw-bold mb-2 text-danger">{{ $kpi['medical_alerts'] ?? 3 }}</div>
                        <span class="badge bg-danger rounded-pill" style="font-size: 0.6rem; padding: 2px 6px;">3 Khẩn cấp</span>
                    </div>
                    <div class="stat-icon" style="background:#FEF2F2; color:#EF4444;"><i class="bi bi-activity"></i></div>
                </div>
            </div>
        </div>

        <!-- Body Analytics (WOW Section) & health alerts log -->
        <div class="row g-4 mb-4">
            <!-- Left: Body Analytics -->
            <div class="col-lg-8">
                <div class="dashboard-card">
                    <div class="card-title-text">Body Analytics HUD - AI Athlete Scan</div>
                    
                    <div class="body-analytics-grid">
                        <!-- Silhouette Outline -->
                        <div class="silhouette-container">
                            <svg viewBox="0 0 100 220" width="100%" height="100%" style="max-height: 380px;">
                                <!-- Head & Neck -->
                                <circle cx="50" cy="22" r="12" fill="none" stroke="#FF5E00" stroke-width="1.5"></circle>
                                <path d="M 45,34 Q 50,37 55,34 L 54,42 L 46,42 Z" fill="none" stroke="#FF5E00" stroke-width="1.5"></path>
                                <!-- Torso & Shoulders -->
                                <path d="M 32,44 C 38,44 42,46 50,46 C 58,46 62,44 68,44 C 70,52 66,74 65,95 C 60,98 40,98 35,95 C 34,74 30,52 32,44 Z" fill="none" stroke="#FF5E00" stroke-width="1.5"></path>
                                <!-- Waist / Hips -->
                                <path d="M 35,95 C 37,112 38,125 36,135 C 45,138 55,138 64,135 C 62,125 63,112 65,95 Z" fill="none" stroke="#FF5E00" stroke-width="1.5"></path>
                                <!-- Legs -->
                                <path d="M 36,135 C 35,160 36,185 38,210 C 39,215 44,215 44,210 C 42,185 43,165 48,140" fill="none" stroke="#FF5E00" stroke-width="1.5"></path>
                                <path d="M 64,135 C 65,160 64,185 62,210 C 61,215 56,215 56,210 C 58,185 57,165 52,140" fill="none" stroke="#FF5E00" stroke-width="1.5"></path>
                            </svg>

                            <!-- Glowing Hotspots -->
                            <div class="health-pointer pointer-posture">
                                <div class="pointer-dot"></div>
                                <div class="pointer-line"></div>
                                <div class="pointer-label">Khớp vai: Cân đối</div>
                            </div>
                            <div class="health-pointer pointer-heart">
                                <div class="pointer-dot"></div>
                                <div class="pointer-line"></div>
                                <div class="pointer-label">Live HR: 74 bpm</div>
                            </div>
                            <div class="health-pointer pointer-waist">
                                <div class="pointer-dot"></div>
                                <div class="pointer-line"></div>
                                <div class="pointer-label">Tỷ lệ mỡ: 13.5%</div>
                            </div>
                            <div class="health-pointer pointer-muscle">
                                <div class="pointer-dot"></div>
                                <div class="pointer-line"></div>
                                <div class="pointer-label">Khối cơ đùi: 32kg</div>
                            </div>
                        </div>

                        <!-- Info Hud -->
                        <div>
                            <h5 class="fw-bold mb-3" style="font-size: 0.9rem;">Thông Số Thể Trạng</h5>
                            <table class="table table-light-custom">
                                <tbody>
                                    <tr>
                                        <td class="text-muted">Chỉ số BMI</td>
                                        <td class="text-end fw-bold">22.4 (Bình thường)</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tỷ lệ trao đổi chất BMR</td>
                                        <td class="text-end fw-bold">1,685 kcal/ngày</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Lượng cơ (Lean Mass)</td>
                                        <td class="text-end fw-bold">58.4 kg</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Năng lượng tiêu thụ TDEE</td>
                                        <td class="text-end fw-bold">2,450 kcal/ngày</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="recovery-hud">
                                <div class="hud-stat-box">
                                    <div class="hud-circle-progress">
                                        <svg>
                                            <circle class="hud-circle-bg" cx="30" cy="30" r="26"></circle>
                                            <circle class="hud-circle-bar" cx="30" cy="30" r="26" stroke="#FF5E00" stroke-dashoffset="52" stroke-dasharray="220"></circle> <!-- 75% -->
                                        </svg>
                                        <div class="position-absolute top-50 start-50 translate-middle font-monospace small fw-bold">75%</div>
                                    </div>
                                    <div class="small text-muted font-monospace" style="font-size: 0.6rem;">Recovery</div>
                                </div>
                                <div class="hud-stat-box">
                                    <div class="hud-circle-progress">
                                        <svg>
                                            <circle class="hud-circle-bg" cx="30" cy="30" r="26"></circle>
                                            <circle class="hud-circle-bar" cx="30" cy="30" r="26" stroke="#10b981" stroke-dashoffset="33" stroke-dasharray="220"></circle> <!-- 85% -->
                                        </svg>
                                        <div class="position-absolute top-50 start-50 translate-middle font-monospace small fw-bold">85%</div>
                                    </div>
                                    <div class="small text-muted font-monospace" style="font-size: 0.6rem;">Hydration</div>
                                </div>
                                <div class="hud-stat-box">
                                    <div class="hud-circle-progress">
                                        <svg>
                                            <circle class="hud-circle-bg" cx="30" cy="30" r="26"></circle>
                                            <circle class="hud-circle-bar" cx="30" cy="30" r="26" stroke="#3b82f6" stroke-dashoffset="88" stroke-dasharray="220"></circle> <!-- 60% -->
                                        </svg>
                                        <div class="position-absolute top-50 start-50 translate-middle font-monospace small fw-bold">60%</div>
                                    </div>
                                    <div class="small text-muted font-monospace" style="font-size: 0.6rem;">Sleep</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: AI Alerts Log -->
            <div class="col-lg-4">
                <div class="dashboard-card">
                    <div class="card-title-text">Cảnh Báo Biến Động Thể Trạng</div>
                    <div class="alert-list">
                        @forelse($recent_alerts ?? [
                            ['member' => 'Trần Văn An', 'issue' => 'Nhịp tim cao (168 bpm)', 'time' => '3 phút trước', 'level' => 'critical'],
                            ['member' => 'Lê Thị Bình', 'issue' => 'SpO2 thấp (92%)', 'time' => '12 phút trước', 'level' => 'critical'],
                            ['member' => 'Nguyễn Văn Cường', 'issue' => 'Hệ số BMI tăng đột ngột', 'time' => '1 giờ trước', 'level' => 'warning']
                        ] as $alert)
                            @php
                                $isCritical = ($alert['level'] ?? ($alert['status'] ?? '')) == 'critical';
                            @endphp
                            <div class="alert-item {{ $isCritical ? 'alert-critical-style' : 'alert-warning-style' }}">
                                <div class="alert-icon-box me-3">
                                    <i class="bi {{ $isCritical ? 'bi-heart-pulse text-danger' : 'bi-exclamation-triangle text-warning' }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold small" style="font-size: 0.85rem;">{{ $alert['member'] }}</div>
                                    <div class="small opacity-75">{{ $alert['issue'] }}</div>
                                </div>
                                <div class="text-end small opacity-75" style="font-size: 0.65rem; font-family: monospace;">{{ $alert['time'] }}</div>
                            </div>
                        @empty
                            <p class="text-center text-muted py-5 small">Không có cảnh báo mới</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- System performance charts -->
        <div class="row g-4">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="card-title-text mb-0">Biểu đồ tăng trưởng doanh thu</div>
                        <select class="form-select form-select-sm w-auto border-secondary bg-white text-dark" style="font-size: 0.75rem;">
                            <option>Tháng này</option>
                        </select>
                    </div>
                    <div style="height: 300px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        let gradOrange = ctx.createLinearGradient(0, 0, 0, 300);
        gradOrange.addColorStop(0, 'rgba(255, 94, 0, 0.15)');
        gradOrange.addColorStop(1, 'rgba(255, 94, 0, 0)');
    
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ Nhật'],
                datasets: [
                    {
                        label: 'Doanh Thu (VNĐ)',
                        data: [12000000, 15000000, 11000000, 22000000, 25200000, 21000000, 28000000],
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
                        grid: { color: 'rgba(0, 0, 0, 0.03)', borderDash: [5, 5] },
                        ticks: { color: '#64748b', font: { size: 10, family: 'Outfit' } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { size: 10, family: 'Outfit' } }
                    }
                }
            }
        });
    });
</script>
@endpush
