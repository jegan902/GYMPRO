<!-- Create Member -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Thêm thành viên mới</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Nhập thông tin hội viên mới</p>
    </div>
    <a href="<?= URL_ROOT ?>/member" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Quay lại
    </a>
</div>

<form action="<?= URL_ROOT ?>/member/store" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">

    <div class="row g-4">
        <!-- Account Info -->
        <div class="col-xl-8">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h5><i class="bi bi-person-badge me-2"></i>Thông tin tài khoản</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại</label>
                            <input type="tel" name="phone" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mật khẩu</label>
                            <input type="text" name="password" class="form-control" value="123456" placeholder="Mặc định: 123456">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Info -->
            <div class="card card-custom mt-4">
                <div class="card-header-custom">
                    <h5><i class="bi bi-heart-pulse me-2"></i>Thông tin cá nhân</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Ngày sinh</label>
                            <input type="date" name="date_of_birth" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Giới tính</label>
                            <select name="gender" class="form-select">
                                <option value="male">Nam</option>
                                <option value="female">Nữ</option>
                                <option value="other">Khác</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Ảnh đại diện</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Chiều cao (cm)</label>
                            <input type="number" name="height" class="form-control" step="0.1" id="height" oninput="calcBMI()">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Cân nặng (kg)</label>
                            <input type="number" name="weight" class="form-control" step="0.1" id="weight" oninput="calcBMI()">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">BMI (tự động)</label>
                            <input type="text" id="bmiDisplay" class="form-control" readonly style="font-weight:700;">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" name="address" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Liên hệ khẩn cấp</label>
                            <input type="text" name="emergency_contact" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SĐT khẩn cấp</label>
                            <input type="tel" name="emergency_phone" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Ghi chú</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-xl-4">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h5><i class="bi bi-info-circle me-2"></i>BMI Guide</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span style="font-size:0.85rem">< 18.5</span>
                            <span class="badge bg-warning">Thiếu cân</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span style="font-size:0.85rem">18.5 – 24.9</span>
                            <span class="badge bg-success">Bình thường</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span style="font-size:0.85rem">25 – 29.9</span>
                            <span class="badge bg-warning">Thừa cân</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span style="font-size:0.85rem">≥ 30</span>
                            <span class="badge bg-danger">Béo phì</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-lg me-2"></i>Lưu thành viên
                </button>
                <a href="<?= URL_ROOT ?>/member" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </div>
    </div>
</form>

<script>
function calcBMI() {
    const h = parseFloat(document.getElementById('height').value);
    const w = parseFloat(document.getElementById('weight').value);
    const display = document.getElementById('bmiDisplay');
    if (h > 0 && w > 0) {
        const bmi = (w / ((h/100) * (h/100))).toFixed(1);
        let label = '';
        if (bmi < 18.5) label = ' (Thiếu cân)';
        else if (bmi < 25) label = ' (Bình thường)';
        else if (bmi < 30) label = ' (Thừa cân)';
        else label = ' (Béo phì)';
        display.value = bmi + label;
    } else {
        display.value = '';
    }
}
</script>
