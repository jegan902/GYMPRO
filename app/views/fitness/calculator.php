<!-- BMI / BMR / TDEE Calculator -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">BMI / BMR / TDEE Calculator</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Tính chỉ số cơ thể và nhu cầu dinh dưỡng</p>
    </div>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-xl-8">
        <div class="card card-custom">
            <div class="card-header-custom">
                <h5><i class="bi bi-calculator me-2"></i>Nhập thông tin</h5>
            </div>
            <div class="card-body">
                <form action="<?= URL_ROOT ?>/fitness/calculate" method="POST" id="calcForm">
                    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Giới tính</label>
                            <div class="d-flex gap-3">
                                <div class="gender-option" data-value="male" onclick="selectGender(this)">
                                    <i class="bi bi-gender-male"></i>
                                    <span>Nam</span>
                                </div>
                                <div class="gender-option" data-value="female" onclick="selectGender(this)">
                                    <i class="bi bi-gender-female"></i>
                                    <span>Nữ</span>
                                </div>
                            </div>
                            <input type="hidden" name="gender" id="genderInput" value="male">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tuổi <span class="text-danger">*</span></label>
                            <input type="number" name="age" class="form-control" placeholder="VD: 25" required min="10" max="100">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Chiều cao (cm) <span class="text-danger">*</span></label>
                            <input type="number" name="height" class="form-control" step="0.1" placeholder="VD: 170" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cân nặng (kg) <span class="text-danger">*</span></label>
                            <input type="number" name="weight" class="form-control" step="0.1" placeholder="VD: 65" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mức độ hoạt động</label>
                            <select name="activity" class="form-select">
                                <option value="1.2">Ít vận động (ngồi văn phòng)</option>
                                <option value="1.375">Nhẹ (tập 1-3 ngày/tuần)</option>
                                <option value="1.55" selected>Vừa phải (tập 3-5 ngày/tuần)</option>
                                <option value="1.725">Mạnh (tập 6-7 ngày/tuần)</option>
                                <option value="1.9">Rất mạnh (vận động viên)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mục tiêu</label>
                            <select name="goal" class="form-select">
                                <option value="lose">Giảm cân</option>
                                <option value="maintain" selected>Duy trì</option>
                                <option value="gain">Tăng cân</option>
                            </select>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-lightning-charge-fill me-2"></i>Tính toán
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Sidebar -->
    <div class="col-xl-4">
        <div class="card card-custom">
            <div class="card-header-custom"><h5><i class="bi bi-info-circle me-2"></i>Giải thích</h5></div>
            <div class="card-body">
                <div class="info-block mb-3">
                    <h6 style="color:var(--primary)">BMI (Body Mass Index)</h6>
                    <p style="font-size:0.8rem;color:var(--text-muted)">Chỉ số khối cơ thể = Cân nặng / (Chiều cao)²</p>
                </div>
                <div class="info-block mb-3">
                    <h6 style="color:var(--success)">BMR (Basal Metabolic Rate)</h6>
                    <p style="font-size:0.8rem;color:var(--text-muted)">Năng lượng cơ thể cần khi nghỉ ngơi (Mifflin-St Jeor)</p>
                </div>
                <div class="info-block">
                    <h6 style="color:var(--warning)">TDEE (Total Daily Energy)</h6>
                    <p style="font-size:0.8rem;color:var(--text-muted)">Tổng năng lượng tiêu hao/ngày = BMR × Hệ số hoạt động</p>
                </div>
            </div>
        </div>

        <div class="card card-custom mt-4">
            <div class="card-header-custom"><h5><i class="bi bi-speedometer me-2"></i>BMI Scale</h5></div>
            <div class="card-body">
                <div class="bmi-scale">
                    <div class="bmi-range" style="background:var(--info-light);color:var(--info)">< 18.5 · Thiếu cân</div>
                    <div class="bmi-range" style="background:var(--success-light);color:var(--success)">18.5 – 24.9 · Bình thường</div>
                    <div class="bmi-range" style="background:var(--warning-light);color:var(--warning)">25 – 29.9 · Thừa cân</div>
                    <div class="bmi-range" style="background:var(--danger-light);color:var(--danger)">≥ 30 · Béo phì</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.gender-option {
    flex:1; padding:16px; border:2px solid var(--border-color); border-radius:var(--radius);
    text-align:center; cursor:pointer; transition:var(--transition);
}
.gender-option:hover { border-color:var(--primary); }
.gender-option.active { border-color:var(--primary); background:var(--primary-light); color:var(--primary); }
.gender-option i { font-size:1.5rem; display:block; margin-bottom:4px; }
.gender-option span { font-size:0.85rem; font-weight:600; }
.bmi-range { padding:8px 12px; border-radius:8px; font-size:0.8rem; font-weight:600; margin-bottom:6px; }
</style>

<script>
document.querySelector('.gender-option[data-value="male"]').classList.add('active');
function selectGender(el) {
    document.querySelectorAll('.gender-option').forEach(e => e.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('genderInput').value = el.dataset.value;
}
</script>
