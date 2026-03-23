<?php require_once APP_ROOT . '/app/views/layouts/public_header.php'; ?>

<main class="bg-light min-vh-100">
    <!-- Hero Header -->
    <section class="profile-header">
        <div class="container overflow-visible">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="d-flex flex-column flex-md-row align-items-center align-items-md-end gap-4 text-center text-md-start">
                        <div class="profile-avatar-wrapper shadow-glow reveal">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="mb-md-1 pb-md-2 text-white">
                            <h1 class="fw-800 display-6 mb-1 reveal" style="transition-delay: 0.1s;"><?= htmlspecialchars($user->full_name) ?></h1>
                            <p class="opacity-75 mb-0 reveal" style="transition-delay: 0.2s;">Hội viên từ <?= date('m/Y', strtotime($user->created_at ?? 'now')) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center text-lg-end mb-md-2 pb-md-3 mt-4 mt-lg-0">
                    <div class="glass-pill d-inline-flex align-items-center gap-2 px-4 py-2 reveal" style="transition-delay: 0.3s;">
                        <span class="status-dot status-active"></span>
                        <span class="text-white fw-bold">Thành viên chính thức</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-absolute bottom-0 start-0 w-100 h-100 opacity-10" style="z-index: 0; background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
    </section>

    <!-- Content Body -->
    <section class="py-5" style="margin-top: 2rem;">
        <div class="container">
            <div class="row g-4">
                <!-- Sidebar Nav -->
                <div class="col-lg-3">
                    <div class="profile-nav-card sticky-top reveal" style="top: 100px;">
                        <div class="nav flex-column nav-pills gap-2">
                            <a href="#info" class="profile-nav-link active" data-bs-toggle="pill">
                                <i class="bi bi-person-circle"></i> Thông tin chung
                            </a>
                            <a href="#metrics" class="profile-nav-link" data-bs-toggle="pill">
                                <i class="bi bi-activity"></i> Chỉ số sức khỏe
                            </a>
                            <a href="#membership" class="profile-nav-link" data-bs-toggle="pill">
                                <i class="bi bi-credit-card-2-front"></i> Gói tập của tôi
                            </a>
                            <hr class="my-3 opacity-10">
                            <a href="<?= URL_ROOT ?>/auth/logout" class="profile-nav-link text-danger">
                                <i class="bi bi-box-arrow-right"></i> Đăng xuất
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="tab-content">
                        <!-- Tab: Thông tin chung -->
                        <div class="tab-pane fade show active" id="info">
                            <div class="glass-card border-0 shadow-sm p-4 p-md-5 rounded-4 reveal">
                                <h3 class="fw-800 mb-4 border-start border-primary border-4 ps-3">Hồ sơ cá nhân</h3>
                                
                                <?php if (Session::hasFlash('success')): ?>
                                    <div class="alert alert-success border-0 rounded-4 mb-4 small px-4 py-3 shadow-sm">
                                        <i class="bi bi-check-circle-fill me-2"></i><?= Session::flash('success')['message'] ?>
                                    </div>
                                <?php endif; ?>

                                <form action="<?= URL_ROOT ?>/profile/update" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
                                    
                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold text-muted small text-uppercase mb-2">Họ và tên</label>
                                            <input type="text" name="full_name" class="form-control profile-form-input" value="<?= htmlspecialchars($user->full_name) ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-muted small text-uppercase mb-2">Địa chỉ Email</label>
                                            <input type="email" class="form-control profile-form-input opacity-75" value="<?= htmlspecialchars($user->email) ?>" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-muted small text-uppercase mb-2">Số điện thoại</label>
                                            <input type="tel" name="phone" class="form-control profile-form-input" value="<?= htmlspecialchars($user->phone ?? '') ?>">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-muted small text-uppercase mb-2">Địa chỉ hiện tại</label>
                                            <textarea name="address" class="form-control profile-form-input" rows="2"><?= htmlspecialchars($member->address ?? '') ?></textarea>
                                        </div>
                                        
                                        <div class="col-12 mt-5">
                                            <h5 class="fw-bold mb-4"><i class="bi bi-shield-lock me-2 text-primary"></i>Liên hệ khẩn cấp</h5>
                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold text-muted small text-uppercase mb-2">Tên người liên hệ</label>
                                                    <input type="text" name="emergency_contact" class="form-control profile-form-input" value="<?= htmlspecialchars($member->emergency_contact ?? '') ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold text-muted small text-uppercase mb-2">Số điện thoại khẩn cấp</label>
                                                    <input type="tel" name="emergency_phone" class="form-control profile-form-input" value="<?= htmlspecialchars($member->emergency_phone ?? '') ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-5">
                                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-glow">
                                                CẬP NHẬT HỒ SƠ <i class="bi bi-send ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Tab: Chỉ số sức khỏe -->
                        <div class="tab-pane fade" id="metrics">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="stat-card-v2 reveal">
                                        <span class="text-muted small fw-bold">CÂN NẶNG</span>
                                        <h2 class="fw-800 mb-0 mt-1"><?= $member->weight ?? '--' ?> <small class="fs-6 opacity-50">kg</small></h2>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card-v2 reveal" style="border-color: #6366f1;">
                                        <span class="text-muted small fw-bold">CHIỀU CAO</span>
                                        <h2 class="fw-800 mb-0 mt-1"><?= $member->height ?? '--' ?> <small class="fs-6 opacity-50">cm</small></h2>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card-v2 reveal" style="border-color: #10b981;">
                                        <span class="text-muted small fw-bold">CHỈ SỐ BMI</span>
                                        <h2 class="fw-800 mb-0 mt-1"><?= $member->bmi ? number_format($member->bmi, 1) : '--' ?></h2>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="glass-card border-0 shadow-sm p-4 p-md-5 rounded-4 reveal">
                                        <h3 class="fw-800 mb-4 border-start border-primary border-4 ps-3">Tiến trình tập luyện</h3>
                                        <div class="p-5 text-center bg-light rounded-5 border border-dashed">
                                            <i class="bi bi-bar-chart-line display-1 text-muted opacity-25 mb-4"></i>
                                            <h5>Chưa có dữ liệu biểu đồ</h5>
                                            <p class="text-muted small">Hãy bắt đầu cập nhật cân nặng hàng tuần để theo dõi tiến trình của bạn.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab: Gói tập -->
                        <div class="tab-pane fade" id="membership">
                            <div class="glass-card border-0 shadow-sm p-4 p-md-5 rounded-4 reveal">
                                <h3 class="fw-800 mb-4 border-start border-primary border-4 ps-3">Gói tập thành viên</h3>
                                
                                <div class="membership-card p-4 rounded-4 text-white mb-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
                                    <div class="position-relative z-index-2">
                                        <div class="d-flex justify-content-between align-items-start mb-4">
                                            <div>
                                                <span class="badge bg-primary rounded-pill mb-2">QUYỀN LỢI PREMIUM</span>
                                                <h2 class="fw-800 mb-0">HỘI VIÊN VÀNG</h2>
                                            </div>
                                            <i class="bi bi-qr-code-scan fs-1 opacity-75"></i>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <p class="small opacity-50 mb-0">Ngày bắt đầu</p>
                                                <p class="fw-bold fs-5">01/03/2024</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="small opacity-50 mb-0">Ngày hết hạn</p>
                                                <p class="fw-bold fs-5 text-warning">01/03/2025</p>
                                            </div>
                                        </div>
                                    </div>
                                    <i class="bi bi-lightning-charge-fill position-absolute bottom-0 end-0 opacity-10" style="font-size: 10rem; margin-bottom: -2rem; margin-right: -1rem;"></i>
                                </div>

                                <div class="alert alert-info border-0 rounded-4 px-4 py-3 d-flex align-items-center gap-3">
                                    <i class="bi bi-info-circle-fill fs-4"></i>
                                    <div>
                                        <p class="mb-0 fw-bold">Gói tập của bạn sẽ hết hạn sau 350 ngày.</p>
                                        <p class="mb-0 small opacity-75">Hãy liên hệ quầy lễ tân để gia hạn hoặc nâng cấp gói tập.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reveals = document.querySelectorAll('.reveal');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });
    reveals.forEach(reveal => revealObserver.observe(reveal));
});
</script>

<?php require_once APP_ROOT . '/app/views/layouts/public_footer.php'; ?>
