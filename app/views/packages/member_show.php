<!-- Member: Chi tiết & Đăng ký gói tập -->
<nav class="mb-4">
    <a href="<?= URL_ROOT ?>/package" class="text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i>Quay lại danh sách gói
    </a>
</nav>

<div class="row g-4">
    <!-- Cột trái: Thông tin gói tập -->
    <div class="col-lg-7">
        <div class="card card-custom">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="feature-icon gradient-bg-1" style="width:56px;height:56px;border-radius:14px;font-size:1.4rem;">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <div>
                        <h4 class="mb-1"><?= htmlspecialchars($package->name) ?></h4>
                        <span class="text-muted" style="font-size:0.85rem">
                            <i class="bi bi-calendar3 me-1"></i><?= $package->duration ?> ngày
                        </span>
                    </div>
                </div>

                <?php if (!empty($package->description)): ?>
                <p class="text-muted mb-4" style="font-size:0.9rem"><?= htmlspecialchars($package->description) ?></p>
                <?php endif; ?>

                <!-- Tính năng gói tập -->
                <?php if (!empty($package->features)): ?>
                <h6 class="mb-3"><i class="bi bi-list-check me-1"></i>Quyền lợi bao gồm</h6>
                <div class="row g-2 mb-4">
                    <?php foreach (explode(',', $package->features) as $f): ?>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 p-2" style="background:var(--bg-secondary);border-radius:8px;">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span style="font-size:0.85rem"><?= trim($f) ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Thông tin thời hạn -->
                <h6 class="mb-3"><i class="bi bi-clock-history me-1"></i>Thời hạn sử dụng</h6>
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div class="p-3" style="background:var(--bg-secondary);border-radius:10px;">
                            <div class="text-muted mb-1" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.5px;">Ngày bắt đầu</div>
                            <div style="font-weight:600;font-size:1rem;">
                                <i class="bi bi-calendar-event text-primary me-1"></i><?= date('d/m/Y', strtotime($startDate)) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3" style="background:var(--bg-secondary);border-radius:10px;">
                            <div class="text-muted mb-1" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.5px;">Ngày kết thúc</div>
                            <div style="font-weight:600;font-size:1rem;">
                                <i class="bi bi-calendar-check text-success me-1"></i><?= date('d/m/Y', strtotime($endDate)) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cột phải: Thanh toán -->
    <div class="col-lg-5">
        <!-- Thông tin hội viên -->
        <div class="card card-custom mb-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-person-fill me-1"></i>Thông tin hội viên</h6>
                <?php if ($member): ?>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between" style="font-size:0.85rem">
                        <span class="text-muted">Họ tên</span>
                        <strong><?= htmlspecialchars($member->full_name) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between" style="font-size:0.85rem">
                        <span class="text-muted">Email</span>
                        <span><?= htmlspecialchars($member->email) ?></span>
                    </div>
                    <?php if (!empty($member->phone)): ?>
                    <div class="d-flex justify-content-between" style="font-size:0.85rem">
                        <span class="text-muted">Điện thoại</span>
                        <span><?= htmlspecialchars($member->phone) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <p class="text-danger mb-0"><i class="bi bi-exclamation-triangle me-1"></i>Không tìm thấy thông tin hội viên.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Thanh toán -->
        <div class="card card-custom" style="border:2px solid var(--primary-light);">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-receipt me-1"></i>Chi tiết thanh toán</h6>
                <div class="d-flex flex-column gap-2 mb-3" style="font-size:0.9rem">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted"><?= htmlspecialchars($package->name) ?></span>
                        <span><?= number_format($package->price, 0, ',', '.') ?>₫</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Thời hạn</span>
                        <span><?= $package->duration ?> ngày</span>
                    </div>
                    <hr class="my-1">
                    <div class="d-flex justify-content-between">
                        <strong>Tổng cộng</strong>
                        <strong style="font-size:1.3rem;color:var(--primary)"><?= number_format($package->price, 0, ',', '.') ?>₫</strong>
                    </div>
                </div>

                <!-- Phương thức thanh toán -->
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:0.85rem">Phương thức thanh toán</label>
                    <div class="d-flex flex-column gap-2">
                        <label class="d-flex align-items-center gap-2 p-2 rounded" style="background:var(--bg-secondary);cursor:pointer;border:1px solid var(--border-color);">
                            <input type="radio" name="payment_display" value="transfer" checked class="form-check-input m-0">
                            <i class="bi bi-bank"></i>
                            <span style="font-size:0.85rem">Chuyển khoản ngân hàng</span>
                        </label>
                        <label class="d-flex align-items-center gap-2 p-2 rounded" style="background:var(--bg-secondary);cursor:pointer;border:1px solid var(--border-color);">
                            <input type="radio" name="payment_display" value="cash" class="form-check-input m-0">
                            <i class="bi bi-cash-coin"></i>
                            <span style="font-size:0.85rem">Thanh toán tại quầy</span>
                        </label>
                    </div>
                </div>

                <?php if ($activePackage): ?>
                    <div class="alert alert-warning mb-0" style="font-size:0.85rem">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Bạn đang có gói <strong><?= htmlspecialchars($activePackage->package_name) ?></strong> 
                        (<?= ucfirst($activePackage->status) ?>). Vui lòng đợi hết hạn hoặc liên hệ nhân viên.
                    </div>
                <?php elseif (!$member): ?>
                    <div class="alert alert-danger mb-0" style="font-size:0.85rem">
                        <i class="bi bi-exclamation-triangle me-1"></i>Không tìm thấy thông tin hội viên. Vui lòng liên hệ quản trị.
                    </div>
                <?php else: ?>
                    <form method="POST" action="<?= URL_ROOT ?>/package/register">
                        <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
                        <input type="hidden" name="package_id" value="<?= $package->id ?>">
                        <button type="submit" class="btn btn-primary w-100 py-2" onclick="return confirm('Xác nhận đăng ký <?= htmlspecialchars($package->name) ?> - <?= number_format($package->price, 0, ',', '.') ?>₫?')">
                            <i class="bi bi-check-circle me-1"></i>Xác nhận đăng ký
                        </button>
                    </form>
                    <p class="text-muted text-center mt-2 mb-0" style="font-size:0.75rem">
                        Sau khi đăng ký, gói tập sẽ được kích hoạt ngay lập tức.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
