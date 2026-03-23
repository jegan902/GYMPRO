<?php require_once APP_ROOT . '/app/views/layouts/public_header.php'; ?>

<main class="bg-white overflow-hidden">
    <!-- Premium Page Header -->
    <section class="py-5 bg-light position-relative">
        <div class="container py-5 text-center reveal">
            <span class="section-label">GIÁ TRỊ XỨNG TẦM</span>
            <h1 class="fw-800 display-4 mb-3 font-heading">Dịch vụ & <span class="text-gradient-premium">Bảng Giá</span></h1>
            <p class="lead text-muted mx-auto mb-0" style="max-width: 800px;">
                Đầu tư cho sức khỏe là khoản đầu tư thông minh nhất. Hãy chọn gói tập phù hợp để bắt đầu hành trình thay đổi vóc dáng ngay hôm nay.
            </p>
        </div>
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25" style="z-index: 0; background-image: radial-gradient(var(--primary-light) 1px, transparent 1px); background-size: 20px 20px;"></div>
    </section>

    <!-- Pricing Section -->
    <section class="py-5">
        <div class="container py-5">
            <div class="row g-4 justify-content-center">
                <!-- Basic Plan -->
                <div class="col-lg-3 col-md-6 reveal" style="transition-delay: 0.1s;">
                    <div class="glass-card p-4 rounded-5 border-0 hover-lift h-100 shadow-sm d-flex flex-column">
                        <div class="mb-4">
                            <span class="badge bg-light text-dark px-3 py-2 rounded-pill mb-3">CƠ BẢN</span>
                            <h3 class="fw-bold mb-0">Tháng</h3>
                            <div class="d-flex align-items-end gap-1 mt-2">
                                <span class="display-6 fw-800 text-primary">500</span>
                                <span class="text-muted mb-2">.000đ / tháng</span>
                            </div>
                        </div>
                        <ul class="list-unstyled mb-5 flex-grow-1">
                            <li class="mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fs-5"></i>
                                <span>Tập gym không giới hạn</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fs-5"></i>
                                <span>Phòng tắm & Xông hơi</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fs-5"></i>
                                <span>Tủ khóa cá nhân (ngày)</span>
                            </li>
                        </ul>
                        <a href="<?= URL_ROOT ?>/auth/register" class="btn btn-outline-primary rounded-pill py-3 fw-bold">Bắt đầu ngay</a>
                    </div>
                </div>

                <!-- Popular Plan -->
                <div class="col-lg-3 col-md-6 reveal" style="transition-delay: 0.2s;">
                    <div class="glass-card p-4 rounded-5 border-2 border-primary hover-lift h-100 shadow d-flex flex-column position-relative" style="background: rgba(255, 94, 0, 0.02); border-style: solid !important;">
                        <div class="position-absolute top-0 start-50 translate-middle">
                            <span class="badge bg-primary px-4 py-2 rounded-pill shadow-sm">PHỔ BIẾN NHẤT</span>
                        </div>
                        <div class="mb-4 mt-2">
                            <span class="badge bg-primary-light text-primary px-3 py-2 rounded-pill mb-3">TIÊU CHUẨN</span>
                            <h3 class="fw-bold mb-0">Quý (3 tháng)</h3>
                            <div class="d-flex align-items-end gap-1 mt-2">
                                <span class="display-6 fw-800 text-primary">1.200</span>
                                <span class="text-muted mb-2">.000đ</span>
                            </div>
                        </div>
                        <ul class="list-unstyled mb-5 flex-grow-1">
                            <li class="mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fs-5"></i>
                                <span>Mọi quyền lợi cơ bản</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fs-5"></i>
                                <span>1 buổi định hướng PT</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fs-5"></i>
                                <span>Nước detox miễn phí</span>
                            </li>
                        </ul>
                        <a href="<?= URL_ROOT ?>/auth/register" class="btn btn-primary rounded-pill py-3 fw-bold shadow-glow">Đăng ký ngay</a>
                    </div>
                </div>

                <!-- 6 Months Plan -->
                <div class="col-lg-3 col-md-6 reveal" style="transition-delay: 0.3s;">
                    <div class="glass-card p-4 rounded-5 border-0 hover-lift h-100 shadow-sm d-flex flex-column">
                        <div class="mb-4">
                            <span class="badge bg-light text-dark px-3 py-2 rounded-pill mb-3">ƯU ĐÃI</span>
                            <h3 class="fw-bold mb-0">Bán niên</h3>
                            <div class="d-flex align-items-end gap-1 mt-2">
                                <span class="display-6 fw-800 text-primary">2.000</span>
                                <span class="text-muted mb-2">.000đ</span>
                            </div>
                        </div>
                        <ul class="list-unstyled mb-5 flex-grow-1">
                            <li class="mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fs-5"></i>
                                <span>Mọi quyền lợi 3 tháng</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fs-5"></i>
                                <span>3 buổi Personal Training</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fs-5"></i>
                                <span>Tủ đồ lưu trữ cá nhân</span>
                            </li>
                        </ul>
                        <a href="<?= URL_ROOT ?>/auth/register" class="btn btn-outline-primary rounded-pill py-3 fw-bold">Chọn gói này</a>
                    </div>
                </div>

                <!-- VIP Plan -->
                <div class="col-lg-3 col-md-6 reveal" style="transition-delay: 0.4s;">
                    <div class="glass-card p-4 rounded-5 border-0 hover-lift h-100 shadow-sm d-flex flex-column" style="background: linear-gradient(145deg, #ffffff, #fefefe);">
                        <div class="mb-4">
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">CAO CẤP</span>
                            <h3 class="fw-bold mb-0">Thẻ VIP Năm</h3>
                            <div class="d-flex align-items-end gap-1 mt-2">
                                <span class="display-6 fw-800 text-primary">3.500</span>
                                <span class="text-muted mb-2">.000đ</span>
                            </div>
                        </div>
                        <ul class="list-unstyled mb-5 flex-grow-1">
                            <li class="mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fs-5"></i>
                                <span>Quyền lợi cao cấp nhất</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fs-5"></i>
                                <span>Massage phục hồi cơ</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fs-5"></i>
                                <span>Khăn tập & Phụ kiện riêng</span>
                            </li>
                        </ul>
                        <a href="<?= URL_ROOT ?>/auth/register" class="btn btn-dark rounded-pill py-3 fw-bold">Trở thành VIP</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Comparison Table Section -->
    <section class="py-5 bg-light">
        <div class="container py-5 reveal">
            <div class="text-center mb-5">
                <span class="section-label">SO SÁNH CHI TIẾT</span>
                <h2 class="display-6 fw-bold font-heading">Đặc quyền <span class="text-primary">Hội viên</span></h2>
            </div>
            
            <div class="comparison-table-wrapper reveal">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>Đặc quyền / Quyền lợi</th>
                            <th>Cơ bản</th>
                            <th>Tiêu chuẩn</th>
                            <th>Ưu đãi</th>
                            <th>VIP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tập luyện không giới hạn thời gian</td>
                            <td><i class="bi bi-check-lg check-icon"></i></td>
                            <td><i class="bi bi-check-lg check-icon"></i></td>
                            <td><i class="bi bi-check-lg check-icon"></i></td>
                            <td><i class="bi bi-check-lg check-icon"></i></td>
                        </tr>
                        <tr>
                            <td>Sử dụng hồ bơi & xông hơi</td>
                            <td><i class="bi bi-check-lg check-icon"></i></td>
                            <td><i class="bi bi-check-lg check-icon"></i></td>
                            <td><i class="bi bi-check-lg check-icon"></i></td>
                            <td><i class="bi bi-check-lg check-icon"></i></td>
                        </tr>
                        <tr>
                            <td>Nước uống Detox & Giải khát</td>
                            <td><i class="bi bi-dash cross-icon"></i></td>
                            <td><i class="bi bi-check-lg check-icon"></i></td>
                            <td><i class="bi bi-check-lg check-icon"></i></td>
                            <td><i class="bi bi-check-lg check-icon"></i></td>
                        </tr>
                        <tr>
                            <td>Bảo lưu gói tập (ngày/năm)</td>
                            <td>15 ngày</td>
                            <td>30 ngày</td>
                            <td>45 ngày</td>
                            <td>60 ngày</td>
                        </tr>
                        <tr>
                            <td>Giờ tập cùng Personal Trainer</td>
                            <td>0</td>
                            <td>1 buổi</td>
                            <td>3 buổi</td>
                            <td>6 buổi</td>
                        </tr>
                        <tr>
                            <td>Dịch vụ Massage chuyên sâu</td>
                            <td><i class="bi bi-dash cross-icon"></i></td>
                            <td><i class="bi bi-dash cross-icon"></i></td>
                            <td><i class="bi bi-dash cross-icon"></i></td>
                            <td><i class="bi bi-check-lg check-icon"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- FAQ Section (Optional but good for conversions) -->
    <section class="py-5">
        <div class="container py-5 reveal">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <span class="section-badge">HỖ TRỢ KHÁCH HÀNG</span>
                    <h2 class="display-6 fw-bold">Câu hỏi thường gặp</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion accordion-flush" id="serviceFaq">
                        <div class="faq-item-premium reveal" style="transition-delay: 0.1s;">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed py-4 px-4 bg-transparent fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#f1">
                                    Tôi có được hoán đổi gói tập sau khi mua không?
                                </button>
                            </h2>
                            <div id="f1" class="accordion-collapse collapse" data-bs-parent="#serviceFaq">
                                <div class="accordion-body px-4 pb-4 text-muted">
                                    GymPro hỗ trợ nâng cấp gói tập trong vòng 7 ngày đầu tiên kể từ ngày kích hoạt. Bạn chỉ cần thanh toán phần chênh lệch giá trị gói tập.
                                </div>
                            </div>
                        </div>
                        <div class="faq-item-premium reveal" style="transition-delay: 0.2s;">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed py-4 px-4 bg-transparent fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#f2">
                                    Làm sao để đăng ký buổi tập trải nghiệm?
                                </button>
                            </h2>
                            <div id="f2" class="accordion-collapse collapse" data-bs-parent="#serviceFaq">
                                <div class="accordion-body px-4 pb-4 text-muted">
                                    Bạn có thể click vào nút "Bắt đầu ngay" hoặc liên hệ trực tiếp qua Hotline/Fanpage để được xếp lịch tập thử 01 buổi miễn phí.
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
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.1 });
    reveals.forEach(reveal => revealObserver.observe(reveal));
});
</script>

<?php require_once APP_ROOT . '/app/views/layouts/public_footer.php'; ?>
