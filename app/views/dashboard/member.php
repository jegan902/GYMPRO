<!-- Member Dashboard -->
<div class="dashboard-grid">
    <!-- Greeting -->
    <div class="mb-4">
        <h2 class="fw-bold">Xin chào, <?= htmlspecialchars(Session::userName()) ?>! 👋</h2>
        <p class="text-muted mb-0">Chúc bạn có buổi tập hiệu quả!</p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Gói tập hiện tại -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-primary">
                <div class="stat-card-body">
                    <div class="stat-info">
                        <h6>Gói tập</h6>
                        <?php if ($activePackage): ?>
                            <h2 style="font-size:1.3rem"><?= htmlspecialchars($activePackage->package_name) ?></h2>
                            <span class="stat-trend up"><i class="bi bi-check-circle"></i> Active</span>
                        <?php else: ?>
                            <h2 style="font-size:1.1rem">Chưa có gói</h2>
                            <span class="stat-trend"><i class="bi bi-info-circle"></i> Đăng ký ngay</span>
                        <?php endif; ?>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <?php if ($activePackage): ?>
                        <span><i class="bi bi-calendar-event"></i> Hết hạn: <?= date('d/m/Y', strtotime($activePackage->end_date)) ?></span>
                    <?php else: ?>
                        <a href="<?= URL_ROOT ?>/package"><i class="bi bi-arrow-right"></i> Xem gói tập</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- BMI -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-success">
                <div class="stat-card-body">
                    <div class="stat-info">
                        <h6>BMI</h6>
                        <?php if ($bmi): ?>
                            <h2><?= $bmi ?></h2>
                            <span class="stat-trend <?= $bmi >= 18.5 && $bmi < 25 ? 'up' : '' ?>">
                                <i class="bi bi-<?= $bmi >= 18.5 && $bmi < 25 ? 'check-circle' : 'exclamation-circle' ?>"></i>
                                <?= $bmiCategory ?>
                            </span>
                        <?php else: ?>
                            <h2>--</h2>
                            <span class="stat-trend"><i class="bi bi-info-circle"></i> Chưa có dữ liệu</span>
                        <?php endif; ?>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="<?= URL_ROOT ?>/fitness"><i class="bi bi-arrow-right"></i> BMI / BMR / TDEE</a>
                </div>
            </div>
        </div>

        <!-- Check-in tháng này -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-warning">
                <div class="stat-card-body">
                    <div class="stat-info">
                        <h6>Check-in tháng này</h6>
                        <h2><?= number_format($monthlyCheckins) ?></h2>
                        <span class="stat-trend"><i class="bi bi-calendar3"></i> buổi tập</span>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-qr-code-scan"></i>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="<?= URL_ROOT ?>/tracking/logs"><i class="bi bi-arrow-right"></i> Nhật ký tập</a>
                </div>
            </div>
        </div>

        <!-- Chỉ số cơ thể -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-info">
                <div class="stat-card-body">
                    <div class="stat-info">
                        <h6>Cân nặng</h6>
                        <?php if ($member && $member->weight > 0): ?>
                            <h2><?= $member->weight ?> kg</h2>
                            <span class="stat-trend">
                                <i class="bi bi-rulers"></i>
                                <?= $member->height ?> cm
                            </span>
                        <?php else: ?>
                            <h2>--</h2>
                            <span class="stat-trend"><i class="bi bi-info-circle"></i> Chưa cập nhật</span>
                        <?php endif; ?>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="<?= URL_ROOT ?>/tracking"><i class="bi bi-arrow-right"></i> Chỉ số cơ thể</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Lịch sử tập gần đây -->
        <div class="col-xl-8">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h5><i class="bi bi-journal-text me-2"></i>Lịch sử tập gần đây</h5>
                    <a href="<?= URL_ROOT ?>/tracking/logs" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Bài tập</th>
                                    <th>Nhóm cơ</th>
                                    <th>Set</th>
                                    <th>Reps</th>
                                    <th>Tạ (kg)</th>
                                    <th>Ngày</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recentWorkouts)): ?>
                                    <?php foreach ($recentWorkouts as $log): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($log->exercise_name) ?></strong></td>
                                        <td>
                                            <span class="badge bg-light text-dark"><?= htmlspecialchars($log->muscle_group_name ?? 'N/A') ?></span>
                                        </td>
                                        <td><?= $log->set_number ?? '-' ?></td>
                                        <td><?= $log->reps ?? '-' ?></td>
                                        <td><?= $log->weight ?? '-' ?></td>
                                        <td><?= date('d/m/Y', strtotime($log->log_date)) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="bi bi-journal-x display-6 d-block mb-2"></i>
                                            Chưa có lịch sử tập luyện
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="col-xl-4">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h5><i class="bi bi-lightning-charge me-2"></i>Truy cập nhanh</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="<?= URL_ROOT ?>/fitness" class="btn btn-outline-primary d-flex align-items-center gap-2">
                            <i class="bi bi-calculator-fill"></i> BMI / BMR / TDEE
                        </a>
                        <a href="<?= URL_ROOT ?>/diet" class="btn btn-outline-success d-flex align-items-center gap-2">
                            <i class="bi bi-egg-fried"></i> Chế độ dinh dưỡng
                        </a>
                        <a href="<?= URL_ROOT ?>/workout" class="btn btn-outline-info d-flex align-items-center gap-2">
                            <i class="bi bi-activity"></i> Giáo án tập
                        </a>
                        <a href="<?= URL_ROOT ?>/tracking" class="btn btn-outline-warning d-flex align-items-center gap-2">
                            <i class="bi bi-speedometer2"></i> Chỉ số cơ thể
                        </a>
                        <a href="<?= URL_ROOT ?>/tracking/logs" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                            <i class="bi bi-journal-text"></i> Nhật ký tập
                        </a>
                        <a href="<?= URL_ROOT ?>/suggestion" class="btn btn-outline-danger d-flex align-items-center gap-2">
                            <i class="bi bi-robot"></i> Gợi ý từ AI
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
