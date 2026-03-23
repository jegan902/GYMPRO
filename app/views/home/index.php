<?php include APP_ROOT . '/app/views/layouts/public_header.php'; ?>

<main class="bg-white">
    <!-- Hero Section V2 -->
    <section class="hero-v2">
        <div class="container overflow-visible">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 reveal">
                    <div class="hero-badge-premium">
                        <span class="badge bg-primary rounded-pill">New</span>
                        <span>Trải nghiệm phòng tập 5 sao tại Việt Nam</span>
                    </div>
                    <h1 class="display-3 fw-800 mb-4 font-heading">
                        Tập Luyện <span class="text-gradient-premium">Chuẩn Mực</span><br>
                        Chinh phục đỉnh cao
                    </h1>
                    <p class="lead text-muted mb-5 pe-lg-5">
                        GYMPRO không chỉ là phòng tập. Chúng tôi là người đồng hành giúp bạn bứt phá giới hạn bằng công nghệ AI và đội ngũ chuyên gia hàng đầu.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="<?= URL_ROOT ?>/auth/register" class="btn btn-premium btn-premium-primary">
                            Bắt đầu ngay <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="<?= URL_ROOT ?>/service" class="btn btn-premium btn-outline-dark">
                            Khám phá dịch vụ
                        </a>
                    </div>
                    
                    <!-- Hero Stats -->
                    <div class="row mt-5 pt-4 g-4 border-top">
                        <div class="col-4">
                            <h3 class="fw-bold mb-0">1200+</h3>
                            <p class="small text-muted mb-0">Hội viên tin dùng</p>
                        </div>
                        <div class="col-4 border-start">
                            <h3 class="fw-bold mb-0">50+</h3>
                            <p class="small text-muted mb-0">HLV Chuyên nghiệp</p>
                        </div>
                        <div class="col-4 border-start">
                            <h3 class="fw-bold mb-0">05+</h3>
                            <p class="small text-muted mb-0">Cơ sở hiện đại</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 position-relative reveal">
                    <!-- Premium Visual Elements -->
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1470&auto=format&fit=crop" 
                             class="img-fluid rounded-5 soft-shadow floating-element" 
                             alt="Gym Experience" 
                             style="z-index: 2; position: relative; border: 8px solid white;">
                        
                        <!-- Floating Glass Cards -->
                        <div class="glass-card p-3 rounded-4 position-absolute shadow-lg floating-element" 
                             style="bottom: -30px; left: -20px; z-index: 3; width: 220px; animation-delay: 1s;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-success text-white rounded-circle p-2">
                                    <i class="bi bi-graph-up-arrow"></i>
                                </div>
                                <div>
                                    <p class="mb-0 small fw-bold">Kết quả vượt trội</p>
                                    <p class="mb-0 text-muted" style="font-size: 0.75rem;">Lộ trình cá nhân hóa</p>
                                </div>
                            </div>
                        </div>

                        <div class="glass-card p-3 rounded-4 position-absolute shadow-lg floating-element" 
                             style="top: 40px; right: -20px; z-index: 3; width: 200px; animation-delay: 2s;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary text-white rounded-circle p-2">
                                    <i class="bi bi-heart-pulse"></i>
                                </div>
                                <div>
                                    <p class="mb-0 small fw-bold">Sức khỏe 24/7</p>
                                    <p class="mb-0 text-muted" style="font-size: 0.75rem;">Theo dõi liên tục</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section V2 -->
    <section class="py-5 bg-light overflow-hidden" id="services">
        <div class="container py-5">
            <div class="text-center mb-5 reveal">
                <span class="section-label">KHÔNG GIAN TẬP LUYỆN</span>
                <h2 class="display-5 fw-bold mb-3 font-heading">Dịch vụ <span class="text-primary">Đặc Quyền</span></h2>
                <div class="mx-auto bg-primary" style="width: 60px; height: 4px; border-radius: 2px;"></div>
            </div>
            
            <div class="row g-4 mt-2">
                <div class="col-lg-3 col-md-6 reveal" style="transition-delay: 0.1s;">
                    <div class="card h-100 border-0 p-4 rounded-4 hover-lift soft-shadow">
                        <div class="icon-box mb-4 bg-primary-light text-primary">
                            <i class="bi bi-fire fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Gym & Fitness</h4>
                        <p class="text-muted small">Ưu tiên trải nghiệm người dùng với thiết bị Technogym nhập khẩu nguyên chiếc.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 reveal" style="transition-delay: 0.2s;">
                    <div class="card h-100 border-0 p-4 rounded-4 hover-lift soft-shadow">
                        <div class="icon-box mb-4 bg-info-light text-info">
                            <i class="bi bi-wind fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Yoga Zen</h4>
                        <p class="text-muted small">Cân bằng thân - tâm và trí trong không gian thiền định yên tĩnh tuyệt đối.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 reveal" style="transition-delay: 0.3s;">
                    <div class="card h-100 border-0 p-4 rounded-4 hover-lift soft-shadow">
                        <div class="icon-box mb-4 bg-success-light text-success">
                            <i class="bi bi-lightning fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-3">HIIT & Cardio</h4>
                        <p class="text-muted small">Nâng cao sức mạnh tim mạch và đốt cháy calo hiệu quả nhất trong thời gian ngắn.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 reveal" style="transition-delay: 0.4s;">
                    <div class="card h-100 border-0 p-4 rounded-4 hover-lift soft-shadow">
                        <div class="icon-box mb-4 bg-warning-light text-warning">
                            <i class="bi bi-person-badge fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Private PT</h4>
                        <p class="text-muted small">HLV 1-1 chuyên sâu đồng hành cùng bạn trên mọi bước hành trình thay đổi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trainers Section V2 -->
    <section class="py-5" id="trainers">
        <div class="container py-5">
            <div class="row align-items-end mb-5 reveal">
                <div class="col-md-6">
                    <span class="section-label">ĐỘI NGŨ CHUYÊN GIA</span>
                    <h2 class="display-5 fw-bold mb-0 font-heading">Huấn Luyện Viên <span class="text-primary">Tiêu Biểu</span></h2>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="<?= URL_ROOT ?>/about#trainers" class="link-primary fw-bold text-decoration-none">Khám phá tất cả chuyên gia <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            
            <div class="row g-4">
                <?php foreach($trainers as $id => $trainer): ?>
                <div class="col-lg-4 reveal" style="transition-delay: <?= $id * 0.1 ?>s;">
                    <div class="card border-0 rounded-5 overflow-hidden soft-shadow hover-lift h-100">
                        <div class="position-relative overflow-hidden" style="height: 400px;">
                            <img src="<?= $trainer['image'] ?>" class="card-img-top h-100 w-100 object-fit-cover" alt="<?= $trainer['name'] ?>">
                            <div class="trainer-overlay-premium d-flex flex-column justify-content-end p-4">
                                <a href="<?= URL_ROOT ?>/trainer/detail/<?= $id ?>" class="btn btn-light rounded-pill fw-bold">Xem hồ sơ chuyên sâu</a>
                            </div>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h4 class="fw-bold mb-1"><?= $trainer['name'] ?></h4>
                            <p class="text-primary small fw-bold text-uppercase letter-spacing-1 mb-3"><?= $trainer['role'] ?></p>
                            <p class="text-muted small italic mb-0">"<?= $trainer['quote'] ?>"</p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- News Section V2 -->
    <section class="py-5 bg-light" id="blog">
        <div class="container py-5">
            <div class="text-center mb-5 reveal">
                <span class="section-label">TIN TỨC & KIẾN THỨC</span>
                <h2 class="display-5 fw-bold mb-3 font-heading">Bài Viết <span class="text-primary">Mới Nhất</span></h2>
                <div class="mx-auto bg-primary" style="width: 60px; height: 4px; border-radius: 2px;"></div>
            </div>
            
            <div class="row g-4">
                <?php foreach($news as $id => $article): ?>
                <div class="col-lg-4 reveal" style="transition-delay: <?= $id * 0.1 ?>s;">
                    <div class="card border-0 rounded-4 overflow-hidden soft-shadow hover-lift h-100">
                        <div class="position-relative">
                            <img src="<?= $article['image'] ?>" class="card-img-top" alt="<?= $article['title'] ?>" style="height: 240px; object-fit: cover;">
                            <span class="position-absolute top-0 start-0 m-3 badge bg-primary"><?= $article['category'] ?></span>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3 h-2-lines"><?= $article['title'] ?></h5>
                            <a href="<?= URL_ROOT ?>/news/detail/<?= $id ?>" class="link-dark fw-bold text-decoration-none small">Đọc bài viết <i class="bi bi-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5 reveal">
        <div class="container py-5">
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <span class="section-label">CHỨNG THỰC THỰC TẾ</span>
                    <h2 class="display-6 fw-bold font-heading">Lắng nghe chia sẻ từ <br><span class="text-primary">Hội viên GymPro</span></h2>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">Hơn <b>1,000+</b> khách hàng đã hài lòng với dịch vụ và đạt được mục tiêu hình thể mong muốn.</p>
                </div>
            </div>
            
            <div class="row g-4">
                <?php foreach($testimonials as $t): ?>
                <div class="col-lg-4">
                    <div class="testimonial-card border-0 soft-shadow hover-lift h-100">
                        <i class="bi bi-quote quote-icon"></i>
                        <div class="mb-4">
                            <div class="d-flex gap-1 text-warning mb-2">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p class="fs-5 fw-medium italic text-dark-emphasis">"<?= $t['content'] ?>"</p>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <img src="<?= $t['avatar'] ?>" class="testimonial-avatar" alt="<?= $t['name'] ?>">
                            <div>
                                <h6 class="fw-bold mb-0"><?= $t['name'] ?></h6>
                                <p class="small text-muted mb-0"><?= $t['role'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- FAQ Section Premium -->
    <section class="py-5 bg-light" id="faqs">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-5 mb-5 mb-lg-0 reveal">
                    <span class="section-label">GIẢI ĐÁP THẮC MẮC</span>
                    <h2 class="display-5 fw-bold mb-4 font-heading">Câu hỏi <span class="text-primary">Thường gặp</span></h2>
                    <p class="text-muted mb-4 pe-lg-4">Chúng tôi luôn lắng nghe và sẵn sàng giải đáp mọi thắc mắc của bạn để chuyến hành trình tập luyện bắt đầu suôn sẻ nhất.</p>
                    <a href="tel:19001234" class="btn btn-premium btn-premium-primary px-4">Hotline hỗ trợ 24/7</a>
                </div>
                <div class="col-lg-7 reveal">
                    <div class="accordion accordion-flush" id="faqAccordion">
                        <?php foreach($faqs as $index => $f): ?>
                        <div class="faq-item-premium p-1 mb-3">
                            <div class="accordion-item border-0 bg-transparent">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-transparent fw-bold py-3 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $index ?>">
                                        <?= $f['question'] ?>
                                    </button>
                                </h2>
                                <div id="collapse-<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted">
                                        <?= $f['answer'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final Premium CTA -->
    <section class="py-5 reveal">
        <div class="container py-5">
            <div class="rounded-5 overflow-hidden position-relative p-5 text-center text-white shadow-lg" 
                 style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=1470&auto=format&fit=crop'); background-size: cover; background-position: center;">
                <div class="position-relative py-5" style="z-index: 2;">
                    <h2 class="display-4 fw-bold mb-4 font-heading">Đừng chần chừ nữa!</h2>
                    <p class="lead mb-5 opacity-75">Tham gia cùng hàng nghìn hội viên khác để sở hữu thân hình hằng mong ước.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="<?= URL_ROOT ?>/auth/register" class="btn btn-premium btn-premium-primary btn-lg px-5">Tham gia ngay</a>
                        <a href="<?= URL_ROOT ?>/service" class="btn btn-premium btn-outline-light btn-lg px-5">Xem bảng giá</a>
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

    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('glass-nav', 'shadow-sm');
        } else {
            navbar.classList.remove('glass-nav', 'shadow-sm');
        }
    });
});
</script>

<style>
.reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.2, 0, 0.2, 1); }
.reveal.active { opacity: 1; transform: translateY(0); }
.fw-800 { font-weight: 800; }
.h-2-lines { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.object-fit-cover { object-fit: cover; }
.letter-spacing-1 { letter-spacing: 1px; }
.trainer-overlay-premium { position: absolute; inset: 0; background: linear-gradient(transparent, rgba(255, 94, 0, 0.9)); opacity: 0; transition: 0.3s; }
.card:hover .trainer-overlay-premium { opacity: 1; }
</style>

<?php include APP_ROOT . '/app/views/layouts/public_footer.php'; ?>
