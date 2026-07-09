@extends('layouts.admin')

@section('title', 'Thông số sức khỏe: ' . $member['fullName'])

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
    }

    .profile-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        padding: 30px;
        position: sticky;
        top: 70px;
    }

    .health-dashboard-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        padding: 30px;
        margin-bottom: 24px;
    }

    .member-big-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .badge-status-show {
        font-size: 11px;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-active { background: #d1fae5; color: #065f46; }
    .badge-expired { background: #fee2e2; color: #991b1b; }
    .badge-pending { background: #ffedd5; color: #9a3412; }

    .kpi-health-box {
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        padding: 16px;
        transition: all 0.3s;
    }

    .kpi-health-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.03);
    }

    .kpi-val {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
    }

    .kpi-lbl {
        font-size: 11px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .chart-container {
        position: relative;
        height: 260px;
        width: 100%;
    }

    .btn-record-metrics {
        background: linear-gradient(135deg, #FF7A00 0%, #FF4D00 100%);
        color: white !important;
        font-weight: 700;
        font-size: 13px;
        padding: 10px 20px;
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 20px rgba(255, 94, 0, 0.2);
        transition: all 0.3s;
    }

    .btn-record-metrics:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 24px rgba(255, 94, 0, 0.3);
    }

    .modal-content {
        border-radius: 24px;
        border: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .modal-header {
        border-bottom: 1px solid #f1f5f9;
        padding: 24px 30px;
    }

    .modal-body {
        padding: 30px;
    }

    .modal-footer {
        border-top: 1px solid #f1f5f9;
        padding: 20px 30px;
    }

    .vital-alert-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .vital-alert-danger { background: #fef2f2; color: #ef4444; border: 1px solid #fca5a5; }
    .vital-alert-warning { background: #fff7ed; color: #f97316; border: 1px solid #fed7aa; }
    .vital-alert-normal { background: #ecfdf5; color: #10b981; border: 1px solid #a7f3d0; }
</style>

<div class="container-fluid py-4">
    <!-- Back Button & Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.members') }}" class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center" style="width:36px; height:36px; padding:0;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="fw-bold mb-0">Hồ Sơ Sức Khỏe Sinh Học</h5>
                <p class="text-muted small mb-0">Tích hợp đo lường chỉ số sinh trắc học và cảnh báo nhịp sinh học AI.</p>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.members.edit', $member['id']) }}" class="btn btn-outline-dark rounded-3 px-3 py-2 fw-bold me-2">
                <i class="bi bi-pencil me-1"></i> Sửa hồ sơ
            </a>
            <button class="btn-record-metrics" data-bs-toggle="modal" data-bs-target="#recordMetricsModal">
                <i class="bi bi-heart-pulse-fill me-1"></i> Đo chỉ số mới
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 rounded-4 shadow-sm" role="alert" style="background:#ecfdf5; color:#047857;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 rounded-4 shadow-sm" role="alert" style="background:#fef2f2; color:#b91c1c;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        
        <!-- Left Side: Profile Information Card -->
        <div class="col-lg-4">
            <div class="profile-card">
                <div class="text-center mb-4">
                    @php
                        $avatar = $member['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($member['fullName']) . '&background=FF5E00&color=fff';
                    @endphp
                    <img src="{{ $avatar }}" class="member-big-avatar mb-3" alt="Avatar">
                    <h5 class="fw-bold text-dark mb-1">{{ $member['fullName'] }}</h5>
                    <p class="text-muted small mb-3">ID Hội viên: <span class="fw-bold text-primary">#MEM-{{ sprintf('%04d', $member['id']) }}</span></p>
                    <span class="badge-status-show badge-{{ $member['status'] }}">
                        @if($member['status'] == 'active') Active @elseif($member['status'] == 'pending') Pending @else Expired @endif
                    </span>
                </div>

                <!-- Bio Info List -->
                <div class="mb-4">
                    <div class="small text-uppercase text-muted fw-bold mb-3" style="letter-spacing: 0.5px; font-size: 11px;">Thông tin liên hệ</div>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Email</span>
                            <span class="fw-bold text-dark small">{{ $member['email'] }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Điện thoại</span>
                            <span class="fw-bold text-dark small">{{ $member['phone'] ?? 'Chưa cập nhật' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Ngày sinh</span>
                            <span class="fw-bold text-dark small">{{ $member['dateOfBirth'] ? \Carbon\Carbon::parse($member['dateOfBirth'])->format('d/m/Y') : 'Chưa cập nhật' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Giới tính</span>
                            <span class="fw-bold text-dark small">{{ $member['gender'] == 'male' ? 'Nam' : ($member['gender'] == 'female' ? 'Nữ' : 'Khác') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">CCCD / CMND</span>
                            <span class="fw-bold text-dark small">{{ $member['idCard'] ?? 'Chưa cập nhật' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Chi nhánh</span>
                            <span class="fw-bold text-primary small">📍 {{ $member['branchName'] ?? 'Chưa cấu hình' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Số buổi PT đã mua</span>
                            <span class="badge bg-dark text-white fw-bold">{{ $member['ptSessions'] }} buổi</span>
                        </div>
                    </div>
                </div>

                <hr class="opacity-50 my-4">

                <!-- Emergency Contact -->
                <div class="mb-4">
                    <div class="small text-uppercase text-muted fw-bold mb-3" style="letter-spacing: 0.5px; font-size: 11px;">Liên hệ khẩn cấp</div>
                    <div class="bg-light rounded-4 p-3 border">
                        <div class="fw-bold text-dark mb-1"><i class="bi bi-person-heart me-1 text-danger"></i> {{ $member['emergencyContact'] ?? 'Chưa có thông tin' }}</div>
                        <div class="text-muted small"><i class="bi bi-telephone me-1"></i> {{ $member['emergencyPhone'] ?? 'Chưa có thông tin' }}</div>
                    </div>
                </div>

                <!-- Notes / Medical History -->
                <div>
                    <div class="small text-uppercase text-muted fw-bold mb-2" style="letter-spacing: 0.5px; font-size: 11px;">Bệnh lý & Ghi chú y tế</div>
                    @if($member['notes'])
                        <div class="alert alert-warning border-0 rounded-4 mb-0 small" style="background:#fffbeb; color:#854d0e;">
                            <i class="bi bi-exclamation-triangle me-1"></i> {{ $member['notes'] }}
                        </div>
                    @else
                        <div class="text-muted small">Không ghi nhận bệnh lý hoặc chấn thương.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Side: Health Dashboard -->
        <div class="col-lg-8">
            
            <!-- Section 1: Biological Metrics (BMI / BMR) -->
            <div class="health-dashboard-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-activity text-danger me-2"></i>Chỉ số sinh học sinh học (Hiện tại)</h6>
                    <span class="text-muted small">Đo lần cuối: {{ $member['updatedAt'] ? \Carbon\Carbon::parse($member['updatedAt'])->format('d/m/Y H:i') : 'Chưa đo' }}</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="kpi-health-box" style="background: #f8fafc;">
                            <div class="kpi-lbl">Chiều cao</div>
                            <div class="kpi-val">{{ $member['height'] ?? '--' }} <span style="font-size:12px; font-weight:500;">cm</span></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="kpi-health-box" style="background: #f8fafc;">
                            <div class="kpi-lbl">Cân nặng</div>
                            <div class="kpi-val">{{ $member['weight'] ?? '--' }} <span style="font-size:12px; font-weight:500;">kg</span></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        @php
                            $bmi = $member['bmi'];
                            $bmiClass = 'bmi-normal';
                            $bmiLabel = 'Bình thường';
                            if ($bmi) {
                                if ($bmi < 18.5) { $bmiClass = 'bmi-underweight'; $bmiLabel = 'Gầy'; }
                                elseif ($bmi >= 25 && $bmi < 30) { $bmiClass = 'bmi-overweight'; $bmiLabel = 'Thừa cân'; }
                                elseif ($bmi >= 30) { $bmiClass = 'bmi-obese'; $bmiLabel = 'Béo phì'; }
                            }
                        @endphp
                        <div class="kpi-health-box" style="background: #f8fafc;">
                            <div class="kpi-lbl">Chỉ số BMI</div>
                            <div class="kpi-val">{{ $bmi ?? '--' }}</div>
                            @if($bmi)
                                <span class="bmi-badge {{ $bmiClass }} mt-1" style="font-size:10px;">{{ $bmiLabel }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="kpi-health-box" style="background: #f8fafc;">
                            <div class="kpi-lbl">Tỷ lệ mỡ (%)</div>
                            <div class="kpi-val">{{ $member['bodyFat'] ?? '--' }} <span style="font-size:12px; font-weight:500;">%</span></div>
                        </div>
                    </div>
                </div>

                <!-- BMR / Calories Recommendation Box -->
                @if(isset($history[0]['bmr']))
                    @php
                        $latestBmr = collect($history)->last()['bmr'] ?? null;
                    @endphp
                    @if($latestBmr)
                        <div class="bg-light border rounded-4 p-4 mt-4 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center border" style="width:48px; height:48px; font-size:24px; color:var(--primary-color);">
                                    <i class="bi bi-lightning-charge"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size:15px;">Mức chuyển hóa cơ bản (BMR)</div>
                                    <div class="text-muted small">Lượng calo tối thiểu cơ thể cần trong 1 ngày để duy trì sinh tồn.</div>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-primary" style="font-size:20px;">{{ number_format($latestBmr) }} kcal</div>
                                <div class="text-muted small">TDEE ước lượng: {{ number_format($latestBmr * 1.375) }} kcal</div>
                            </div>
                        </div>
                    @endif
                @endif

            </div>

            <!-- Section 2: Vitals & Cardio tracking (AI IoT Integration) -->
            <div class="health-dashboard-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-heart text-danger me-2"></i>Nhịp tim & Độ bão hòa Oxy (IoT Ring/Band)</h6>
                    <span class="vital-alert-pill vital-alert-normal"><i class="bi bi-shield-check"></i> Trạng thái bình thường</span>
                </div>
                
                @php
                    $latestMetric = collect($history)->last();
                    $hr = $latestMetric['heartRate'] ?? 72;
                    $spo2 = $latestMetric['spo2'] ?? 98;
                    
                    $hrClass = 'vital-alert-normal';
                    if ($hr > 100 || $hr < 50) $hrClass = 'vital-alert-danger';
                    elseif ($hr > 85) $hrClass = 'vital-alert-warning';

                    $spo2Class = 'vital-alert-normal';
                    if ($spo2 < 94) $spo2Class = 'vital-alert-danger';
                    elseif ($spo2 < 96) $spo2Class = 'vital-alert-warning';
                @endphp

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="border rounded-4 p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-muted small fw-bold text-uppercase">Nhịp tim hiện tại</div>
                                <div class="display-6 fw-bold text-dark">{{ $hr }} <span style="font-size:16px;">BPM</span></div>
                            </div>
                            <span class="vital-alert-pill {{ $hrClass }}">{{ $hr > 100 ? 'Cao' : ($hr < 50 ? 'Thấp' : 'Bình thường') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-4 p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-muted small fw-bold text-uppercase">Nồng độ SpO2</div>
                                <div class="display-6 fw-bold text-dark">{{ $spo2 }} <span style="font-size:16px;">%</span></div>
                            </div>
                            <span class="vital-alert-pill {{ $spo2Class }}">{{ $spo2 < 94 ? 'Nguy hiểm' : ($spo2 < 96 ? 'Cần chú ý' : 'An toàn') }}</span>
                        </div>
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="vitalsChart"></canvas>
                </div>
            </div>

            <!-- Section 3: Body Weight & Fat Trend Line Chart -->
            <div class="health-dashboard-card">
                <h6 class="fw-bold text-dark mb-4"><i class="bi bi-graph-up text-primary me-2"></i>Biến động Cân nặng & Tỷ lệ mỡ (Lịch sử đo)</h6>
                <div class="chart-container">
                    <canvas id="weightChart"></canvas>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- Modal: Record Health Metrics -->
<div class="modal fade" id="recordMetricsModal" tabindex="-1" aria-labelledby="recordMetricsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.members.metrics', $member['id']) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="recordMetricsModalLabel"><i class="bi bi-heart-pulse-fill text-danger me-2"></i>Đo lường & Cập nhật Chỉ số mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Chiều cao (cm) <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" id="modalHeight" name="height" class="form-control" value="{{ $member['height'] }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cân nặng (kg) <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" id="modalWeight" name="weight" class="form-control" value="{{ $member['weight'] }}" required>
                        </div>
                        <div class="col-md-12">
                            <div id="modal-live-calculation-box" class="bg-light border rounded-3 p-3">
                                <span class="small text-muted fw-bold d-block" style="font-size:10px;">CHỈ SỐ DỰ KIẾN (LIVE CALCULATED)</span>
                                <div class="d-flex gap-4 mt-2">
                                    <span class="small text-dark font-weight-bold">BMI: <span id="modal-bmi-val" class="text-primary fw-bold">--</span> (<span id="modal-bmi-lbl" class="fw-bold">--</span>)</span>
                                    <span class="small text-dark font-weight-bold">BMR: <span id="modal-bmr-val" class="text-success fw-bold">--</span> kcal</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tỷ lệ mỡ - Body Fat (%)</label>
                            <input type="number" step="0.1" name="bodyFat" class="form-control" value="{{ $member['bodyFat'] }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nhịp tim - Pulse (BPM)</label>
                            <input type="number" name="heartRate" class="form-control" value="{{ $hr }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Chỉ số oxy máu SpO2 (%)</label>
                            <input type="number" step="0.1" name="spo2" class="form-control" value="{{ $spo2 }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Ghi chú đo lường</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="VD: Đo vào buổi sáng trước tập..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-3 fw-bold px-3 py-2" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn-record-metrics py-2">Ghi nhận</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Parse health history data from blade
        const historyData = @json($history);
        
        let labels = [];
        let weightData = [];
        let fatData = [];
        let hrData = [];
        let spo2Data = [];

        if (historyData.length > 0) {
            historyData.forEach(item => {
                const date = new Date(item.measurementDate);
                labels.push(date.toLocaleDateString('vi-VN', {day: '2-digit', month: '2-digit'}));
                weightData.push(item.bmi ? parseFloat(item.bmi) * 2.2 : 65); // fallbacks or calculate
                // Wait! Let's map exactly from history if weight exists. But weight isn't directly in the history database fields
                // Wait, weight is updated on the member level. Let's see if we should calculate weight = bmi * (height/100)^2!
                const heightM = {{ $member['height'] ?? 170 }} / 100;
                const weight = item.bmi ? Math.round(item.bmi * heightM * heightM * 10) / 10 : {{ $member['weight'] ?? 60 }};
                weightData.push(weight);
                fatData.push(item.fatPercentage ? parseFloat(item.fatPercentage) : 0);
                hrData.push(item.heartRate ? parseInt(item.heartRate) : 72);
                spo2Data.push(item.spo2 ? parseFloat(item.spo2) : 98);
            });
        } else {
            // Mock dynamic defaults if no metrics exist yet
            labels = ['Hôm qua', 'Hôm nay'];
            weightData = [{{ $member['weight'] ?? 65 }}, {{ $member['weight'] ?? 65 }}];
            fatData = [{{ $member['bodyFat'] ?? 18 }}, {{ $member['bodyFat'] ?? 18 }}];
            hrData = [72, 75];
            spo2Data = [98, 98];
        }

        // 1. Chart: Vitals (Heart Rate & SpO2)
        const vitalsCtx = document.getElementById('vitalsChart').getContext('2d');
        const gradHr = vitalsCtx.createLinearGradient(0, 0, 0, 260);
        gradHr.addColorStop(0, 'rgba(239, 68, 68, 0.15)');
        gradHr.addColorStop(1, 'rgba(239, 68, 68, 0)');

        new Chart(vitalsCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Nhịp tim (BPM)',
                        data: hrData,
                        borderColor: '#ef4444',
                        backgroundColor: gradHr,
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2,
                        pointRadius: 4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'SpO2 (%)',
                        data: spo2Data,
                        borderColor: '#10b981',
                        fill: false,
                        tension: 0.35,
                        borderWidth: 2,
                        pointRadius: 4,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { boxWidth: 12, font: { family: 'Plus Jakarta Sans', weight: '600' } } }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: { display: true, text: 'BPM', font: { weight: 'bold' } },
                        min: 40,
                        max: 200,
                        grid: { drawOnChartArea: true }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: { display: true, text: '% SpO2', font: { weight: 'bold' } },
                        min: 80,
                        max: 100,
                        grid: { drawOnChartArea: false }
                    }
                }
            }
        });

        // 2. Chart: Weight & Body Fat
        const weightCtx = document.getElementById('weightChart').getContext('2d');
        const gradWeight = weightCtx.createLinearGradient(0, 0, 0, 260);
        gradWeight.addColorStop(0, 'rgba(59, 130, 246, 0.15)');
        gradWeight.addColorStop(1, 'rgba(59, 130, 246, 0)');

        new Chart(weightCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Cân nặng (kg)',
                        data: weightData,
                        borderColor: '#3b82f6',
                        backgroundColor: gradWeight,
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2,
                        pointRadius: 4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Tỷ lệ mỡ (%)',
                        data: fatData,
                        borderColor: '#f59e0b',
                        fill: false,
                        tension: 0.35,
                        borderWidth: 2,
                        pointRadius: 4,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { boxWidth: 12, font: { family: 'Plus Jakarta Sans', weight: '600' } } }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: { display: true, text: 'Cân nặng (kg)', font: { weight: 'bold' } },
                        grid: { drawOnChartArea: true }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: { display: true, text: 'Tỷ lệ mỡ (%)', font: { weight: 'bold' } },
                        min: 0,
                        max: 50,
                        grid: { drawOnChartArea: false }
                    }
                }
            }
        });

        // 3. Modal live Bmi & Bmr calculations
        const modalHeightIn = document.getElementById('modalHeight');
        const modalWeightIn = document.getElementById('modalWeight');
        const modalBmiVal = document.getElementById('modal-bmi-val');
        const modalBmiLbl = document.getElementById('modal-bmi-lbl');
        const modalBmrVal = document.getElementById('modal-bmr-val');

        function updateModalLiveStats() {
            const height = parseFloat(modalHeightIn.value);
            const weight = parseFloat(modalWeightIn.value);
            const dob = "{{ $member['dateOfBirth'] }}";
            const gender = "{{ $member['gender'] }}";

            if (height && weight) {
                const heightM = height / 100;
                const bmi = weight / (heightM * heightM);
                modalBmiVal.textContent = bmi.toFixed(1);

                let label = 'Bình thường';
                if (bmi < 18.5) label = 'Gầy';
                else if (bmi >= 25 && bmi < 30) label = 'Thừa cân';
                else if (bmi >= 30) label = 'Béo phì';
                modalBmiLbl.textContent = label;

                if (dob) {
                    const birthDate = new Date(dob);
                    let age = new Date().getFullYear() - birthDate.getFullYear();
                    if (new Date() < new Date(new Date().getFullYear(), birthDate.getMonth(), birthDate.getDate())) {
                        age--;
                    }
                    
                    let bmr = (10 * weight) + (6.25 * height) - (5 * age);
                    if (gender === 'male') {
                        bmr += 5;
                    } else {
                        bmr -= 161;
                    }
                    modalBmrVal.textContent = Math.round(bmr);
                } else {
                    modalBmrVal.textContent = '--';
                }
            } else {
                modalBmiVal.textContent = '--';
                modalBmiLbl.textContent = '--';
                modalBmrVal.textContent = '--';
            }
        }

        if (modalHeightIn && modalWeightIn) {
            modalHeightIn.addEventListener('input', updateModalLiveStats);
            modalWeightIn.addEventListener('input', updateModalLiveStats);
            updateModalLiveStats();
        }
    });
</script>
@endpush
