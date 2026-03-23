<!-- Edit Member -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Sửa thông tin thành viên</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem"><?= htmlspecialchars($member->full_name) ?></p>
    </div>
    <a href="<?= URL_ROOT ?>/member" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Quay lại
    </a>
</div>

<form action="<?= URL_ROOT ?>/member/update/<?= $member->id ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">

    <div class="row g-4">
        <div class="col-xl-8">
            <!-- Account Info -->
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h5><i class="bi bi-person-badge me-2"></i>Thông tin tài khoản</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($member->full_name) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($member->email) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại</label>
                            <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($member->phone ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="active" <?= $member->status === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= $member->status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                <option value="expired" <?= $member->status === 'expired' ? 'selected' : '' ?>>Expired</option>
                            </select>
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
                            <input type="date" name="date_of_birth" class="form-control" value="<?= $member->date_of_birth ?? '' ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Giới tính</label>
                            <select name="gender" class="form-select">
                                <option value="male" <?= $member->gender === 'male' ? 'selected' : '' ?>>Nam</option>
                                <option value="female" <?= $member->gender === 'female' ? 'selected' : '' ?>>Nữ</option>
                                <option value="other" <?= $member->gender === 'other' ? 'selected' : '' ?>>Khác</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Đổi ảnh đại diện</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Chiều cao (cm)</label>
                            <input type="number" name="height" class="form-control" step="0.1" id="height" value="<?= $member->height ?? '' ?>" oninput="calcBMI()">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Cân nặng (kg)</label>
                            <input type="number" name="weight" class="form-control" step="0.1" id="weight" value="<?= $member->weight ?? '' ?>" oninput="calcBMI()">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">BMI (tự động)</label>
                            <input type="text" id="bmiDisplay" class="form-control" readonly style="font-weight:700;" value="<?= $member->bmi ? number_format($member->bmi, 1) : '' ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($member->address ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Liên hệ khẩn cấp</label>
                            <input type="text" name="emergency_contact" class="form-control" value="<?= htmlspecialchars($member->emergency_contact ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SĐT khẩn cấp</label>
                            <input type="tel" name="emergency_phone" class="form-control" value="<?= htmlspecialchars($member->emergency_phone ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Ghi chú</label>
                            <textarea name="notes" class="form-control" rows="3"><?= htmlspecialchars($member->notes ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-xl-4">
            <!-- Avatar -->
            <div class="card card-custom text-center">
                <div class="card-body py-4">
                    <div class="member-avatar-lg mx-auto mb-3">
                        <?php if (!empty($member->avatar)): ?>
                            <img src="<?= URL_ROOT ?>/uploads/<?= $member->avatar ?>" alt="">
                        <?php else: ?>
                            <i class="bi bi-person-fill"></i>
                        <?php endif; ?>
                    </div>
                    <h5 class="mb-1"><?= htmlspecialchars($member->full_name) ?></h5>
                    <p class="text-muted mb-0" style="font-size:0.85rem"><?= htmlspecialchars($member->email) ?></p>
                </div>
            </div>

            <!-- Active Package -->
            <?php if ($activePackage): ?>
            <div class="card card-custom mt-4">
                <div class="card-header-custom">
                    <h5><i class="bi bi-box-seam me-2"></i>Gói tập hiện tại</h5>
                </div>
                <div class="card-body">
                    <h6 class="text-primary mb-2"><?= htmlspecialchars($activePackage->package_name) ?></h6>
                    <p style="font-size:0.85rem" class="mb-1">
                        <i class="bi bi-calendar3 me-1"></i>
                        <?= date('d/m/Y', strtotime($activePackage->start_date)) ?> → <?= date('d/m/Y', strtotime($activePackage->end_date)) ?>
                    </p>
                    <span class="status-badge status-<?= $activePackage->status ?>"><?= ucfirst($activePackage->status) ?></span>
                </div>
            </div>
            <?php endif; ?>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-lg me-2"></i>Cập nhật
                </button>
                <a href="<?= URL_ROOT ?>/member" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </div>
    </div>
</form>

<style>
.member-avatar-lg {
    width: 100px; height: 100px; border-radius: 50%;
    background: var(--primary-light); display: flex; align-items: center;
    justify-content: center; overflow: hidden;
}
.member-avatar-lg img { width: 100%; height: 100%; object-fit: cover; }
.member-avatar-lg i { font-size: 2.5rem; color: var(--primary); }
</style>

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
    } else { display.value = ''; }
}
calcBMI();
</script>
