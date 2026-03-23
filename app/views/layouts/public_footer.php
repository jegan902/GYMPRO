    <!-- Footer -->
    <footer class="landing-footer pt-5 pb-3 bg-white border-top mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="footer-brand mb-3">
                        <i class="bi bi-lightning-charge-fill text-primary"></i>
                        <span class="text-dark">GYM<strong>PRO</strong></span>
                    </div>
                    <p class="text-muted">Hệ thống phòng tập thể hình chuẩn quốc tế, mang đến trải nghiệm nâng tầm sức khỏe chuyên nghiệp.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3 text-dark">Liên kết nhanh</h5>
                    <ul class="footer-links list-unstyled text-muted">
                        <li class="mb-2"><a href="<?= URL_ROOT ?>/about" class="text-decoration-none">Giới thiệu về chúng tôi</a></li>
                        <li class="mb-2"><a href="<?= URL_ROOT ?>/service" class="text-decoration-none">Dịch vụ & Bảng giá</a></li>
                        <li class="mb-2"><a href="<?= URL_ROOT ?>/trainers" class="text-decoration-none">Đội ngũ PT</a></li>
                        <li class="mb-2"><a href="<?= URL_ROOT ?>/news" class="text-decoration-none">Tin tức</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3 text-dark">Liên hệ</h5>
                    <ul class="footer-links list-unstyled text-muted">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2 text-primary"></i> 123 Đường Sức Khỏe, Quận 1, TP.HCM</li>
                        <li class="mb-2"><i class="bi bi-telephone me-2 text-primary"></i> Hotline: 1900 123 456</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2 text-primary"></i> hotro@gympro.vn</li>
                        <li class="mb-2"><i class="bi bi-clock me-2 text-primary"></i> Mở cửa: 05:00 - 23:00 mỗi ngày</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-3 border-secondary">
            <p class="text-center text-muted mb-0 small">&copy; <?= date('Y') ?> GYMPRO SYSTEM. Xây Dựng Bản Thân.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect (Only for home page where it is transparent initially)
        <?php if (isset($is_home) && $is_home): ?>
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('landingNav');
            if (window.scrollY > 50) {
                nav.style.background = '#ffffff';
                nav.classList.add('shadow-sm');
                nav.style.borderBottom = '1px solid #dee2e6';
            } else {
                nav.style.background = 'transparent';
                nav.classList.remove('shadow-sm');
                nav.style.borderBottom = 'none';
            }
        });
        <?php endif; ?>
    </script>
</body>
</html>
