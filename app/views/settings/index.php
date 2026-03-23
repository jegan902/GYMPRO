<!-- Settings Page -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Cấu hình hệ thống</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Tùy chỉnh thông tin và thông số phòng gym</p>
    </div>
</div>

<form action="<?= URL_ROOT ?>/setting/update" method="POST">
    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">

    <div class="row g-4">
        <!-- General Info -->
        <div class="col-xl-6">
            <div class="card card-custom h-100">
                <div class="card-header-custom"><h5><i class="bi bi-building me-2"></i>Thông tin phòng gym</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Tên phòng gym</label>
                        <input type="text" name="gym_name" class="form-control" value="<?= htmlspecialchars($settings['gym_name']->setting_value ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($settings['address']->setting_value ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hotline</label>
                        <input type="text" name="hotline" class="form-control" value="<?= htmlspecialchars($settings['hotline']->setting_value ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giờ cao điểm</label>
                        <input type="text" name="peak_hour_range" class="form-control" value="<?= htmlspecialchars($settings['peak_hour_range']->setting_value ?? '') ?>" placeholder="VD: 17:00-20:00">
                    </div>
                </div>
            </div>
        </div>

        <!-- Fitness Settings -->
        <div class="col-xl-6">
            <div class="card card-custom h-100">
                <div class="card-header-custom"><h5><i class="bi bi-gear me-2"></i>Cấu hình Fitness</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Công thức BMR</label>
                        <select name="calorie_formula_type" class="form-select">
                            <option value="mifflin" <?= ($settings['calorie_formula_type']->setting_value ?? '') === 'mifflin' ? 'selected' : '' ?>>Mifflin-St Jeor</option>
                            <option value="harris" <?= ($settings['calorie_formula_type']->setting_value ?? '') === 'harris' ? 'selected' : '' ?>>Harris-Benedict</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mức hoạt động mặc định</label>
                        <select name="default_activity_level" class="form-select">
                            <option value="1.2" <?= ($settings['default_activity_level']->setting_value ?? '') === '1.2' ? 'selected' : '' ?>>Ít vận động (1.2)</option>
                            <option value="1.375" <?= ($settings['default_activity_level']->setting_value ?? '') === '1.375' ? 'selected' : '' ?>>Nhẹ nhàng (1.375)</option>
                            <option value="1.55" <?= ($settings['default_activity_level']->setting_value ?? '') === '1.55' ? 'selected' : '' ?>>Vừa phải (1.55)</option>
                            <option value="1.725" <?= ($settings['default_activity_level']->setting_value ?? '') === '1.725' ? 'selected' : '' ?>>Năng động (1.725)</option>
                            <option value="1.9" <?= ($settings['default_activity_level']->setting_value ?? '') === '1.9' ? 'selected' : '' ?>>Rất năng động (1.9)</option>
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label" style="font-size:0.75rem">Macro tăng cân (C/P/F)</label>
                            <input type="text" name="macro_ratio_bulk" class="form-control form-control-sm" value="<?= htmlspecialchars($settings['macro_ratio_bulk']->setting_value ?? '40/30/30') ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-size:0.75rem">Macro giảm mỡ (C/P/F)</label>
                            <input type="text" name="macro_ratio_cut" class="form-control form-control-sm" value="<?= htmlspecialchars($settings['macro_ratio_cut']->setting_value ?? '40/40/20') ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Check-in tối đa/ngày</label>
                        <input type="number" name="max_checkin_per_day" class="form-control" value="<?= htmlspecialchars($settings['max_checkin_per_day']->setting_value ?? '2') ?>" min="1" max="5">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-check-lg me-2"></i>Lưu cấu hình</button>
        </div>
    </div>
</form>
