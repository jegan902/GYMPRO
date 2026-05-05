@extends('layouts.admin')

@section('title', 'Hồ Sơ Cá Nhân')

@push('styles')
    <style>
        :root {
            --profile-bg: #f8f9fa;
            --card-bg: #ffffff;
            --input-bg: #ffffff;
            --orange-primary: #FF5E00;
            --orange-hover: #e65500;
            --text-main: #2d3436;
            --text-muted: #636e72;
        }

        .profile-container {
            background-color: var(--profile-bg);
            min-height: 100vh;
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
        }

        .glass-header {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .avatar-section {
            position: relative;
            width: 120px;
            height: 120px;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 8px 25px rgba(255, 94, 0, 0.15);
        }

        .avatar-edit-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--orange-primary);
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            cursor: pointer;
            border: 3px solid #fff;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .avatar-edit-btn:hover {
            transform: scale(1.1) rotate(15deg);
            background: var(--orange-hover);
        }

        .profile-card {
            background: #fff;
            border-radius: 8px;
            padding: 8px;
            border: 1px solid #edf2f7;
            height: 100%;
        }

        .card-title {
            color: var(--text-main);
            font-size: 1.15rem;
            font-weight: 800;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .card-title i {
            color: var(--orange-primary);
            background: rgba(255, 94, 0, 0.08);
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-group-custom {
            margin-bottom: 20px;
        }

        .form-label-custom {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 10px;
            display: block;
            padding-left: 5px;
        }

        .form-input-custom {
            background: #f1f3f5 !important;
            border: 2px solid transparent !important;
            color: var(--text-main) !important;
            border-radius: 15px;
            padding: 12px 18px;
            width: 100%;
            transition: all 0.3s;
            font-weight: 500;
            padding: 5px;
        }


        .form-label-custom {
            font-size: 0.5rem;
            font-weight: 700;
            color: #718096;
            text-transform: uppercase;
            margin-bottom: 1px;
            display: block;
            letter-spacing: 0.01em;
        }

        .form-input-custom {
            width: 100%;
            height: 24px;
            padding: 0 8px;
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            font-size: 0.7rem;
            color: #2d3436;
        }

        .form-input-custom:focus {
            background: #fff;
            border-color: var(--orange-primary);
            box-shadow: 0 0 0 1px rgba(255, 94, 0, 0.1);
            outline: none;
        }

        .glass-header {
            background: #fff;
            border-radius: 8px;
            border: 1px solid #edf2f7;
            padding: 8px 12px;
        }

        .update-btn {
            background: #fbc531;
            color: #2d3436;
            font-weight: 800;
            font-size: 0.55rem;
            height: 22px;
            padding: 0 10px;
            border-radius: 3px;
            border: none;
            text-transform: uppercase;
        }

        .avatar-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            border: 1.5px solid var(--orange-primary);
        }

        .avatar-section {
            position: relative;
            width: 40px !important;
            height: 40px !important;
        }

        .avatar-edit-btn {
            position: absolute;
            background: var(--orange-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 14px !important;
            height: 14px !important;
            bottom: 0;
            right: 0;
            font-size: 8px;
        }

        .card-title {
            font-size: 0.65rem !important;
            margin-bottom: 5px !important;
        }

        .card-title i {
            font-size: 0.7rem;
        }

        .stat-box-micro {
            background: #f8f9fa;
            border: 1px solid #eee;
            border-radius: 5px;
            padding: 4px 6px;
        }

        .stat-label-micro {
            font-size: 0.5rem;
            color: #636e72;
            font-weight: 700;
        }

        .stat-value-micro {
            font-size: 0.7rem;
            font-weight: 800;
        }

        .stat-input-micro {
            width: 100%;
            border: none;
            background: transparent;
            font-size: 0.7rem;
            font-weight: 800;
            color: inherit;
            padding: 0;
            outline: none;
        }

        .stat-input-micro:focus {
            color: var(--orange-primary);
        }

        .history-card-custom {
            background: #f8fafc;
            border-radius: 8px;
            padding: 0 8px 8px 8px;
            border: 1px solid #edf2f7;
            max-height: 100px;
            overflow-y: auto;
        }

        .history-card-custom::-webkit-scrollbar {
            width: 3px;
        }

        .history-card-custom::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .history-card-custom::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .history-table {
            width: 100%;
            font-size: 0.55rem;
            border-collapse: separate;
            border-spacing: 0 4px;
        }

        .history-table th {
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            padding: 4px;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            background: #f8fafc;
            z-index: 10;
        }

        .history-table td {
            padding: 6px 4px;
            vertical-align: middle;
            color: #334155;
        }

        .text-success-custom {
            color: #4ade80 !important;
        }

        .text-info-custom {
            color: #38bdf8 !important;
        }
    </style>
@endpush

@section('content')
    <div class="profile-container animate-fade-in">
        <div class="container-fluid p-4">
            <!-- Breadcrumb / Header -->
            <div class="d-flex align-items-center gap-2 mb-4">
                <span class="text-muted">Dashboard</span>
                <span class="text-muted">/</span>
                <span class="text-dark fw-bold">Hồ sơ cá nhân</span>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert"
                    style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; border: 1px solid rgba(46, 204, 113, 0.2);">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- User Info Header -->
                <div class="glass-header mb-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-section">
                                <img src="{{ $user['user']['avatar'] ? (str_starts_with($user['user']['avatar'], 'http') ? $user['user']['avatar'] : (config('services.backend.url_base') . $user['user']['avatar'])) : 'https://i.pravatar.cc/150' }}"
                                    class="avatar-img" id="avatarPreview">
                                <label for="avatarInput" class="avatar-edit-btn">
                                    <i class="bi bi-camera"></i>
                                </label>
                                <input type="file" id="avatarInput" name="avatar" hidden onchange="previewImage(this)">
                            </div>
                            <div class="ms-1">
                                <div class="d-flex align-items-center gap-2 mb-0">
                                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.9rem;">
                                        {{ $user['user']['fullName'] }}</h6>
                                    <span class="badge"
                                        style="background: #fff7ed; color: var(--orange-primary); font-size: 0.55rem; border: 1px solid #ffedd5; padding: 2px 6px;">{{ strtoupper($user['user']['role']) }}</span>
                                </div>
                                <div class="d-flex flex-column" style="gap: 1px;">
                                    <div style="font-size: 0.65rem; color: #718096;"><i class="bi bi-envelope me-1"></i>
                                        {{ $user['user']['email'] }}</div>
                                    <div style="font-size: 0.65rem; color: #718096;"><i class="bi bi-calendar3 me-1"></i> Thành
                                        viên từ: {{ date('d/m/Y', strtotime($user['user']['createdAt'])) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Basic Info Card -->
                <div class="profile-card mb-4">
                    <div class="card-title">
                        <i class="bi bi-person-circle text-warning"></i>
                        <span class="fw-bold">Thông Tin Cơ Bản</span>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group-custom">
                                <label class="form-label-custom">Họ và tên</label>
                                <input type="text" name="fullName" class="form-input-custom"
                                    value="{{ old('fullName', $user['user']['fullName']) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-custom">
                                <label class="form-label-custom">Email (Không thể thay đổi)</label>
                                <input type="email" class="form-input-custom opacity-75"
                                    value="{{ $user['user']['email'] }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-custom">
                                <label class="form-label-custom">Số điện thoại</label>
                                <input type="text" name="phone" class="form-input-custom"
                                    value="{{ old('phone', $user['user']['phone']) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-custom">
                                <label class="form-label-custom">Giới tính</label>
                                <select name="gender" id="info-gender" class="form-input-custom">
                                    <option value="male" {{ (old('gender', ($user['member']['gender'] ?? '')) == 'male') ? 'selected' : '' }}>Nam</option>
                                    <option value="female" {{ (old('gender', ($user['member']['gender'] ?? '')) == 'female') ? 'selected' : '' }}>Nữ</option>
                                    <option value="other" {{ (old('gender', ($user['member']['gender'] ?? '')) == 'other') ? 'selected' : '' }}>Khác</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-custom">
                                <label class="form-label-custom">Quốc tịch</label>
                                <input type="text" name="nationality" class="form-input-custom"
                                    value="{{ old('nationality', ($user['member']['nationality'] ?? 'Việt Nam')) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-custom">
                                <label class="form-label-custom">Ngày sinh</label>
                                <input type="date" name="dateOfBirth" id="info-birthday" class="form-input-custom"
                                    value="{{ old('dateOfBirth', (isset($user['member']['dateOfBirth']) ? date('Y-m-d', strtotime($user['member']['dateOfBirth'])) : '')) }}">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group-custom">
                                <label class="form-label-custom">Địa chỉ</label>
                                <input type="text" name="address" class="form-input-custom"
                                    value="{{ old('address', ($user['member']['address'] ?? '')) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-custom">
                                <label class="form-label-custom">CMND/CCCD</label>
                                <input type="text" name="idCard" class="form-input-custom"
                                    value="{{ old('idCard', ($user['member']['idCard'] ?? '')) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-custom">
                                <label class="form-label-custom">Mật khẩu mới</label>
                                <input type="password" name="newPassword" class="form-input-custom"
                                    placeholder="Bỏ trống nếu không đổi">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-custom">
                                <label class="form-label-custom">Xác nhận mật khẩu</label>
                                <input type="password" name="newPassword_confirmation" class="form-input-custom"
                                    placeholder="Nhập lại mật khẩu">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Stats Row -->
                <div class="row g-2 mb-4">
                    <!-- Membership -->
                    <div class="col-lg-4">
                        <div class="profile-card">
                            <div class="card-title mb-3">
                                <i class="bi bi-card-heading text-warning"></i>
                                <span class="fw-bold">Thông Tin Thẻ Thành Viên</span>
                            </div>
                            <div class="p-2 rounded-3" style="background: #2d3436; color: #fff;">
                                <div class="row g-2">
                                    <div class="col-7">
                                        <div style="font-size: 0.6rem; color: #b2bec3; font-weight: 700;">Gói Tập</div>
                                        <div class="fw-bold" style="font-size: 0.8rem;">
                                            {{ ($user['subscription']['packageName'] ?? 'N/A') }}</div>
                                    </div>
                                    <div class="col-5 text-end">
                                        <div style="font-size: 0.6rem; color: #b2bec3; font-weight: 700;">Số PT Còn Lại
                                        </div>
                                        <div class="fw-bold" style="font-size: 0.8rem;">
                                            {{ ($user['member']['ptSessions'] ?? 0) }}</div>
                                    </div>
                                    <div class="col-4">
                                        <div style="font-size: 0.6rem; color: #b2bec3; font-weight: 700;">Từ Ngày</div>
                                        <div class="fw-bold" style="font-size: 0.7rem;">
                                            {{ ($user['subscription']['startDate'] ?? 'N/A') }}</div>
                                    </div>
                                    <div class="col-4">
                                        <div style="font-size: 0.6rem; color: #b2bec3; font-weight: 700;">Hết Hạn</div>
                                        <div class="fw-bold" style="font-size: 0.7rem;">
                                            {{ ($user['subscription']['endDate'] ?? 'N/A') }}</div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div style="font-size: 0.6rem; color: #b2bec3; font-weight: 700;">Trạng Thái</div>
                                        <div class="fw-bold" style="font-size: 0.7rem; color: #ff7675;">
                                            {{ strtoupper(($user['subscription']['status'] ?? 'NONE')) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Body Metrics -->
                    <div class="col-lg-4">
                        <div class="profile-card h-100 d-flex flex-column">
                            <div class="card-title">
                                <i class="bi bi-heart-pulse text-warning"></i>
                                <span class="fw-bold">Số Liệu Cơ Thể</span>
                            </div>
                            <div class="flex-grow-1 d-flex flex-column justify-content-center">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="stat-box-micro h-100">
                                            <div class="stat-label-micro">Cân Nặng (kg)</div>
                                            <input type="number" step="0.1" name="Weight" id="metric-weight" class="stat-input-micro" 
                                                value="{{ ($user['metrics']['weight'] ?? "--") }}" placeholder="--">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-box-micro h-100">
                                            <div class="stat-label-micro">Chiều Cao (cm)</div>
                                            <input type="number" step="0.1" name="Height" id="metric-height" class="stat-input-micro" 
                                                value="{{ ($user['metrics']['height'] ?? "--") }}" placeholder="--">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-box-micro h-100">
                                            <div class="stat-label-micro">BMI <span id="bmi-status" class="ms-1 fw-bold" style="font-size: 0.45rem;"></span></div>
                                            <input type="number" step="0.01" name="Bmi" id="metric-bmi" class="stat-input-micro text-orange" 
                                                value="{{ ($user['metrics']['bmi'] ?? "--") }}" placeholder="--" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-box-micro h-100">
                                            <div class="stat-label-micro">Mỡ Cơ Thể (%) <span id="bodyfat-status" class="ms-1 fw-bold" style="font-size: 0.45rem;"></span></div>
                                            <input type="number" step="0.1" name="BodyFat" id="metric-bodyfat" class="stat-input-micro text-info" 
                                                value="{{ ($user['metrics']['bodyFat'] ?? "--") }}" placeholder="--" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- History -->
                    <div class="col-lg-4">
                        <div class="profile-card d-flex flex-column h-100">
                            <div class="card-title">
                                <i class="bi bi-clock-history text-warning"></i>
                                <span class="fw-bold">Lịch Sử Tập Luyện & Thanh Toán</span>
                            </div>
                            <div class="history-card-custom flex-grow-1">
                                <table class="history-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Tập okin</th>
                                            <th>Từ</th>
                                            <th>Stats</th>
                                            <th class="text-end">Toán</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>05/05/2026</td>
                                            <td>Check</td>
                                            <td class="text-success-custom fw-bold">Gold</td>
                                            <td class="text-end fw-bold">10 buổi</td>
                                        </tr>
                                        <tr>
                                            <td>04/05/2026</td>
                                            <td>Check</td>
                                            <td class="text-success-custom fw-bold">Gold</td>
                                            <td class="text-end fw-bold">9 buổi</td>
                                        </tr>
                                        <tr>
                                            <td>03/05/2026</td>
                                            <td>Thanh toán</td>
                                            <td class="text-info-custom fw-bold">Success</td>
                                            <td class="text-end fw-bold">1.200.000 VNĐ</td>
                                        </tr>
                                        <tr>
                                            <td>02/05/2026</td>
                                            <td>Check</td>
                                            <td class="text-success-custom fw-bold">Gold</td>
                                            <td class="text-end fw-bold">8 buổi</td>
                                        </tr>
                                        <tr>
                                            <td>01/05/2026</td>
                                            <td>Check</td>
                                            <td class="text-success-custom fw-bold">Gold</td>
                                            <td class="text-end fw-bold">7 buổi</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="text-end mt-3">
                    <button type="submit" class="update-btn" style="height: 28px; padding: 0 20px; font-size: 0.65rem;">
                        <i class="bi bi-check-lg me-1"></i> LƯU THAY ĐỔI
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function calculateMetrics() {
            const weight = parseFloat(document.getElementById('metric-weight').value);
            const heightCm = parseFloat(document.getElementById('metric-height').value);
            const gender = document.getElementById('info-gender').value;
            const birthday = document.getElementById('info-birthday').value;

            if (!weight || !heightCm) return;

            // 1. Calculate BMI
            const heightM = heightCm / 100;
            const bmi = (weight / (heightM * heightM)).toFixed(2);
            document.getElementById('metric-bmi').value = bmi;

            // BMI Status
            let status = "";
            let color = "";
            if (bmi < 18.5) { status = "(Gầy)"; color = "#e17055"; }
            else if (bmi < 25) { status = "(Bình thường)"; color = "#00b894"; }
            else if (bmi < 30) { status = "(Thừa cân)"; color = "#d6a01d"; }
            else { status = "(Béo phì)"; color = "#d63031"; }
            
            const statusEl = document.getElementById('bmi-status');
            statusEl.innerText = status;
            statusEl.style.color = color;

            // 2. Calculate Age
            if (birthday && gender) {
                const birthYear = new Date(birthday).getFullYear();
                const currentYear = new Date().getFullYear();
                const age = currentYear - birthYear;

                if (age > 0) {
                    // 3. Calculate Body Fat %
                    // Male = 1, Female = 0
                    const genderVal = (gender === 'male') ? 1 : 0;
                    const bodyFat = ((1.20 * bmi) + (0.23 * age) - (10.8 * genderVal) - 5.4).toFixed(1);
                    document.getElementById('metric-bodyfat').value = bodyFat;

                    // Body Fat Status
                    let bfStatus = "";
                    let bfColor = "";
                    if (gender === 'male') {
                        if (bodyFat < 14) { bfStatus = "(Excellent)"; bfColor = "#00b894"; }
                        else if (bodyFat < 18) { bfStatus = "(Fit)"; bfColor = "#00cec9"; }
                        else if (bodyFat < 25) { bfStatus = "(Average)"; bfColor = "#d6a01d"; }
                        else { bfStatus = "(Obese)"; bfColor = "#d63031"; }
                    } else {
                        if (bodyFat < 21) { bfStatus = "(Excellent)"; bfColor = "#00b894"; }
                        else if (bodyFat < 25) { bfStatus = "(Fit)"; bfColor = "#00cec9"; }
                        else if (bodyFat < 32) { bfStatus = "(Average)"; bfColor = "#d6a01d"; }
                        else { bfStatus = "(Obese)"; bfColor = "#d63031"; }
                    }
                    const bfStatusEl = document.getElementById('bodyfat-status');
                    bfStatusEl.innerText = bfStatus;
                    bfStatusEl.style.color = bfColor;
                } else {
                    document.getElementById('metric-bodyfat').value = "";
                    document.getElementById('metric-bodyfat').placeholder = "Ngày sinh lỗi";
                }
            } else {
                document.getElementById('metric-bodyfat').value = "";
                document.getElementById('metric-bodyfat').placeholder = "Thiếu NS/GT";
            }
        }

        // Listen for inputs
        document.getElementById('metric-weight').addEventListener('input', calculateMetrics);
        document.getElementById('metric-height').addEventListener('input', calculateMetrics);
        document.getElementById('info-gender').addEventListener('change', calculateMetrics);
        document.getElementById('info-birthday').addEventListener('change', calculateMetrics);

        // Run on load and after small delay to ensure values are populated
        document.addEventListener('DOMContentLoaded', function() {
            // Small timeout to ensure browser has filled saved values
            setTimeout(calculateMetrics, 100);
        });

        // Also run on window load as fallback
        window.addEventListener('load', calculateMetrics);

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush