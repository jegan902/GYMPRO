@extends('layouts.admin')

@section('title', 'Thêm mới Hội viên')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
    }

    .form-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        padding: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    }

    .section-title {
        font-size: 14px;
        font-weight: 800;
        color: #1e293b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 20px;
        padding-bottom: 8px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-label {
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        padding: 10px 14px;
        font-size: 13.5px;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(255, 94, 0, 0.15);
    }

    .btn-submit {
        background: var(--primary-color);
        color: white;
        font-weight: 700;
        font-size: 13.5px;
        padding: 12px 24px;
        border-radius: 10px;
        border: none;
        box-shadow: 0 10px 15px -3px rgba(255, 94, 0, 0.25);
        transition: all 0.3s;
    }

    .btn-submit:hover {
        background: var(--secondary-color);
        transform: translateY(-1px);
        box-shadow: 0 12px 20px -3px rgba(255, 94, 0, 0.35);
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
        font-weight: 700;
        font-size: 13.5px;
        padding: 12px 24px;
        border-radius: 10px;
        border: none;
        transition: all 0.2s;
        text-decoration: none !important;
        text-align: center;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
</style>

<div class="container-fluid py-4">
    <!-- Back Button & Title -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.members') }}" class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center" style="width:36px; height:36px; padding:0;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h5 class="fw-bold mb-0">Thêm Mới Hội Viên</h5>
            <p class="text-muted small mb-0">Tạo tài khoản và ghi nhận chỉ số cơ bản cho hội viên mới.</p>
        </div>
    </div>

    <!-- Error Validation Messages -->
    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4" style="background:#fef2f2; color:#b91c1c;">
            <div class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i> Vui lòng sửa các lỗi sau:</div>
            <ul class="mb-0 px-3 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.members.store') }}" method="POST">
        @csrf
        <div class="form-card">
            
            <!-- SECTION 1: Tài khoản đăng nhập -->
            <div class="section-title">
                <i class="bi bi-shield-lock text-primary"></i> 1. Thông tin tài khoản đăng nhập
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" name="fullName" class="form-control" value="{{ old('fullName') }}" required placeholder="VD: Nguyễn Văn A">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Địa chỉ Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="VD: member@gmail.com">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Mật khẩu ban đầu <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required placeholder="Tối thiểu 6 ký tự" value="123456">
                </div>
            </div>

            <!-- SECTION 2: Thông tin cá nhân -->
            <div class="section-title">
                <i class="bi bi-person text-success"></i> 2. Thông tin cá nhân & Liên hệ
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="VD: 0912345678">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Giới tính <span class="text-danger">*</span></label>
                    <select name="gender" id="gender" class="form-select" required>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Ngày sinh</label>
                    <input type="date" name="dateOfBirth" id="dateOfBirth" class="form-control" value="{{ old('dateOfBirth') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Số CCCD / ID Card</label>
                    <input type="text" name="idCard" class="form-control" value="{{ old('idCard') }}" placeholder="Số CCCD gồm 12 số">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Quốc tịch</label>
                    <input type="text" name="nationality" class="form-control" value="{{ old('nationality', 'Vietnam') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Chi nhánh đăng ký</label>
                    <select name="branchId" class="form-select">
                        <option value="">Chọn chi nhánh</option>
                        @foreach($branches as $b)
                            @php
                                $bId = data_get($b, 'id') ?? data_get($b, 'Id');
                                $bName = data_get($b, 'name') ?? data_get($b, 'Name');
                            @endphp
                            <option value="{{ $bId }}" {{ old('branchId') == $bId ? 'selected' : '' }}>{{ $bName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Địa chỉ liên hệ</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Số nhà, Tên đường, Quận/Huyện, Tỉnh/Thành phố">
                </div>
            </div>

            <!-- SECTION 3: Chỉ số sức khỏe đo lường -->
            <div class="section-title">
                <i class="bi bi-heart-pulse text-danger"></i> 3. Chỉ số sức khỏe (Tính BMI/BMR tự động)
            </div>
            <p class="text-muted small mb-3"><i class="bi bi-info-circle-fill text-info me-1"></i> Hệ thống sẽ tự động tạo log sức khỏe và tính toán chỉ số BMI/BMR dựa trên các thông số này.</p>
            <div class="row g-3 mb-4 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">Chiều cao (cm)</label>
                    <input type="number" step="0.1" id="height" name="height" class="form-control" value="{{ old('height') }}" placeholder="VD: 172.5">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Cân nặng (kg)</label>
                    <input type="number" step="0.1" id="weight" name="weight" class="form-control" value="{{ old('weight') }}" placeholder="VD: 68">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tỷ lệ mỡ - Body Fat (%)</label>
                    <input type="number" step="0.1" name="bodyFat" class="form-control" value="{{ old('bodyFat') }}" placeholder="VD: 18.2">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Số buổi PT đã mua</label>
                    <input type="number" name="ptSessions" class="form-control" value="{{ old('ptSessions', 0) }}">
                </div>
                <div class="col-md-4">
                    <div id="live-calculation-box" class="bg-light border rounded-3 p-2 d-none" style="margin-bottom: 2px;">
                        <span class="small text-muted fw-bold d-block" style="font-size:10px;">CHỈ SỐ DỰ KIẾN</span>
                        <div class="d-flex gap-3 mt-1">
                            <span class="small text-dark font-weight-bold">BMI: <span id="bmi-val" class="text-primary fw-bold"></span> (<span id="bmi-lbl" class="fw-bold"></span>)</span>
                            <span class="small text-dark font-weight-bold">BMR: <span id="bmr-val" class="text-success fw-bold"></span> kcal</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: Liên hệ khẩn cấp -->
            <div class="section-title">
                <i class="bi bi-telephone-outbound text-warning"></i> 4. Người liên hệ khẩn cấp
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Tên người liên hệ khẩn cấp</label>
                    <input type="text" name="emergencyContact" class="form-control" value="{{ old('emergencyContact') }}" placeholder="VD: Trần Văn B (Bố/Mẹ/Vợ)">
                </div>
                <div class="col-md-6">
                    <label class="form-label">SĐT liên hệ khẩn cấp</label>
                    <input type="text" name="emergencyPhone" class="form-control" value="{{ old('emergencyPhone') }}" placeholder="VD: 0987654321">
                </div>
            </div>

            <!-- SECTION 5: Ghi chú thêm -->
            <div class="section-title">
                <i class="bi bi-journal-text text-dark"></i> 5. Ghi chú & Tiểu sử bệnh lý
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-12">
                    <label class="form-label">Ghi chú y tế hoặc mục tiêu tập luyện</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Ghi chú chấn thương cũ, bệnh nền (tim mạch, hen suyễn) hoặc mục tiêu cụ thể (giảm cân, tăng cơ)...">{{ old('notes') }}</textarea>
                </div>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-3 mt-4">
                <a href="{{ route('admin.members') }}" class="btn-cancel">Hủy bỏ</a>
                <button type="submit" class="btn-submit">
                    <i class="bi bi-save me-1"></i> Lưu hội viên
                </button>
            </div>

        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const heightIn = document.getElementById('height');
    const weightIn = document.getElementById('weight');
    const dobIn = document.getElementById('dateOfBirth');
    const genderIn = document.getElementById('gender');
    const calcBox = document.getElementById('live-calculation-box');
    const bmiVal = document.getElementById('bmi-val');
    const bmiLbl = document.getElementById('bmi-lbl');
    const bmrVal = document.getElementById('bmr-val');

    function updateLiveStats() {
        const height = parseFloat(heightIn.value);
        const weight = parseFloat(weightIn.value);
        const dob = dobIn.value;
        const gender = genderIn.value;

        if (height && weight) {
            calcBox.classList.remove('d-none');
            const heightM = height / 100;
            const bmi = weight / (heightM * heightM);
            bmiVal.textContent = bmi.toFixed(1);

            let label = 'Bình thường';
            if (bmi < 18.5) label = 'Gầy';
            else if (bmi >= 25 && bmi < 30) label = 'Thừa cân';
            else if (bmi >= 30) label = 'Béo phì';
            bmiLbl.textContent = label;

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
                bmrVal.textContent = Math.round(bmr);
            } else {
                bmrVal.textContent = '--';
            }
        } else {
            calcBox.classList.add('d-none');
        }
    }

    heightIn.addEventListener('input', updateLiveStats);
    weightIn.addEventListener('input', updateLiveStats);
    dobIn.addEventListener('change', updateLiveStats);
    genderIn.addEventListener('change', updateLiveStats);
});
</script>
@endpush
@endsection
