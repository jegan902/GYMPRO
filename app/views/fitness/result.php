<!-- BMI / BMR / TDEE Result -->
<?php
    // BMI Classification
    if ($bmi < 18.5)      { $bmiLabel = 'Thiếu cân';  $bmiColor = 'var(--info)';    $bmiClass = 'info'; }
    elseif ($bmi < 25)    { $bmiLabel = 'Bình thường'; $bmiColor = 'var(--success)'; $bmiClass = 'success'; }
    elseif ($bmi < 30)    { $bmiLabel = 'Thừa cân';   $bmiColor = 'var(--warning)'; $bmiClass = 'warning'; }
    else                  { $bmiLabel = 'Béo phì';     $bmiColor = 'var(--danger)';  $bmiClass = 'danger'; }

    $goalLabels = ['lose' => 'Giảm cân', 'maintain' => 'Duy trì', 'gain' => 'Tăng cân'];
    $actLabels  = [1.2 => 'Ít vận động', 1.375 => 'Nhẹ', 1.55 => 'Vừa phải', 1.725 => 'Mạnh', 1.9 => 'Rất mạnh'];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Kết quả phân tích</h4>
    <a href="<?= URL_ROOT ?>/fitness" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Tính lại</a>
</div>

<!-- Main Metrics -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="result-metric-card" style="border-top:3px solid <?= $bmiColor ?>">
            <div class="metric-label">BMI</div>
            <div class="metric-value" style="color:<?= $bmiColor ?>"><?= $bmi ?></div>
            <div class="metric-desc">
                <span class="badge bg-<?= $bmiClass ?>"><?= $bmiLabel ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="result-metric-card" style="border-top:3px solid var(--success)">
            <div class="metric-label">BMR</div>
            <div class="metric-value" style="color:var(--success)"><?= number_format($bmr) ?></div>
            <div class="metric-desc">kcal/ngày (nghỉ ngơi)</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="result-metric-card" style="border-top:3px solid var(--warning)">
            <div class="metric-label">TDEE</div>
            <div class="metric-value" style="color:var(--warning)"><?= number_format($tdee) ?></div>
            <div class="metric-desc">kcal/ngày (hoạt động)</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Calories & Macros -->
    <div class="col-xl-8">
        <div class="card card-custom">
            <div class="card-header-custom">
                <h5><i class="bi bi-fire me-2"></i>Calories & Macronutrients mục tiêu</h5>
                <span class="badge bg-primary"><?= $goalLabels[$goal] ?? 'Duy trì' ?></span>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div style="font-size:3rem;font-weight:800;color:var(--primary)"><?= number_format($targetCal) ?></div>
                    <div class="text-muted">kcal / ngày</div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="macro-card" style="background: rgba(108,99,255,0.1); border-left: 4px solid var(--primary);">
                            <div class="macro-icon"><i class="bi bi-egg-fill" style="color:var(--primary)"></i></div>
                            <div>
                                <div class="macro-value"><?= $protein ?>g</div>
                                <div class="macro-label">Protein</div>
                                <div class="macro-cal"><?= $protein * 4 ?> kcal</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="macro-card" style="background: rgba(255,193,7,0.1); border-left: 4px solid var(--warning);">
                            <div class="macro-icon"><i class="bi bi-lightning-fill" style="color:var(--warning)"></i></div>
                            <div>
                                <div class="macro-value"><?= $carbs ?>g</div>
                                <div class="macro-label">Carbs</div>
                                <div class="macro-cal"><?= $carbs * 4 ?> kcal</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="macro-card" style="background: rgba(239,68,68,0.1); border-left: 4px solid var(--danger);">
                            <div class="macro-icon"><i class="bi bi-droplet-fill" style="color:var(--danger)"></i></div>
                            <div>
                                <div class="macro-value"><?= $fat ?>g</div>
                                <div class="macro-label">Fat</div>
                                <div class="macro-cal"><?= $fat * 9 ?> kcal</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Macro ratio bar -->
                <div class="macro-bar mt-4">
                    <?php
                        $totalMacroCal = ($protein*4) + ($carbs*4) + ($fat*9);
                        $pPct = round(($protein*4) / $totalMacroCal * 100);
                        $cPct = round(($carbs*4) / $totalMacroCal * 100);
                        $fPct = 100 - $pPct - $cPct;
                    ?>
                    <div class="macro-bar-segment" style="width:<?= $pPct ?>%;background:var(--primary)"></div>
                    <div class="macro-bar-segment" style="width:<?= $cPct ?>%;background:var(--warning)"></div>
                    <div class="macro-bar-segment" style="width:<?= $fPct ?>%;background:var(--danger)"></div>
                </div>
                <div class="d-flex justify-content-between mt-2" style="font-size:0.75rem;color:var(--text-muted)">
                    <span><i class="bi bi-circle-fill" style="color:var(--primary);font-size:0.5rem"></i> Protein <?= $pPct ?>%</span>
                    <span><i class="bi bi-circle-fill" style="color:var(--warning);font-size:0.5rem"></i> Carbs <?= $cPct ?>%</span>
                    <span><i class="bi bi-circle-fill" style="color:var(--danger);font-size:0.5rem"></i> Fat <?= $fPct ?>%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Input Summary -->
    <div class="col-xl-4">
        <div class="card card-custom">
            <div class="card-header-custom"><h5><i class="bi bi-person me-2"></i>Thông tin nhập</h5></div>
            <div class="card-body">
                <div class="detail-item mb-3">
                    <label>Giới tính</label>
                    <span><?= $gender === 'male' ? 'Nam' : 'Nữ' ?></span>
                </div>
                <div class="detail-item mb-3">
                    <label>Tuổi</label>
                    <span><?= $age ?> tuổi</span>
                </div>
                <div class="detail-item mb-3">
                    <label>Chiều cao</label>
                    <span><?= $height ?> cm</span>
                </div>
                <div class="detail-item mb-3">
                    <label>Cân nặng</label>
                    <span><?= $weight ?> kg</span>
                </div>
                <div class="detail-item mb-3">
                    <label>Hoạt động</label>
                    <span><?= $actLabels[$activity] ?? 'Vừa phải' ?></span>
                </div>
                <div class="detail-item">
                    <label>Mục tiêu</label>
                    <span><?= $goalLabels[$goal] ?? 'Duy trì' ?></span>
                </div>
            </div>
        </div>

        <!-- Recommendations -->
        <div class="card card-custom mt-4">
            <div class="card-header-custom"><h5><i class="bi bi-lightbulb me-2"></i>Gợi ý</h5></div>
            <div class="card-body" style="font-size:0.85rem">
                <?php if ($goal === 'lose'): ?>
                    <p>🥗 Ăn nhiều rau xanh và protein để no lâu</p>
                    <p>💧 Uống đủ 2-3L nước/ngày</p>
                    <p>🏃 Kết hợp cardio 30p/ngày</p>
                <?php elseif ($goal === 'gain'): ?>
                    <p>🍚 Chia nhỏ bữa ăn (5-6 bữa/ngày)</p>
                    <p>💪 Tập nặng + progressive overload</p>
                    <p>😴 Ngủ đủ 7-8 tiếng/đêm</p>
                <?php else: ?>
                    <p>⚖️ Cân bằng giữa protein, carbs và fat</p>
                    <p>🏋️ Tập luyện đều đặn 3-5 ngày/tuần</p>
                    <p>📊 Theo dõi cân nặng hàng tuần</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.result-metric-card {
    background:var(--bg-card); border:1px solid var(--border-color);
    border-radius:var(--radius-lg); padding:24px; text-align:center;
}
.metric-label { font-size:0.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; }
.metric-value { font-size:2.5rem; font-weight:800; line-height:1; margin-bottom:8px; }
.metric-desc { font-size:0.8rem; color:var(--text-secondary); }
.macro-card {
    display:flex; align-items:center; gap:16px; padding:16px; border-radius:var(--radius); 
}
.macro-icon { font-size:1.5rem; }
.macro-value { font-size:1.3rem; font-weight:800; }
.macro-label { font-size:0.75rem; font-weight:600; color:var(--text-muted); }
.macro-cal { font-size:0.7rem; color:var(--text-muted); }
.macro-bar { display:flex; height:8px; border-radius:4px; overflow:hidden; }
.macro-bar-segment { height:100%; }
.detail-item { display:flex; flex-direction:column; gap:2px; }
.detail-item label { font-size:0.7rem; font-weight:600; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; }
.detail-item span { font-size:0.85rem; }
</style>
