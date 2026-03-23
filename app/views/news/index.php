<?php require_once APP_ROOT . '/app/views/layouts/public_header.php'; ?>

<main class="bg-white overflow-hidden">
    <!-- Premium News Hero & Search -->
    <section class="py-5 bg-dark text-white position-relative">
        <div class="container py-5 text-center reveal position-relative" style="z-index: 2;">
            <span class="badge bg-primary px-3 py-2 rounded-pill mb-3 text-uppercase fw-bold" style="letter-spacing: 2px;">TẠP CHÍ SỨC KHỎE</span>
            <h1 class="fw-800 display-2 mb-4 font-heading text-white">Tin tức & <span class="text-gradient-premium">Kỹ thuật</span></h1>
            <p class="lead opacity-75 mx-auto mb-5" style="max-width: 800px;">
                Kho lưu trữ kiến thức khổng lồ về dinh dưỡng, kỹ thuật tập luyện và động lực từ cộng đồng GymPro. 
                Chúng tôi không chỉ là phòng tập, chúng tôi là lối sống của bạn.
            </p>
            
            <!-- Global Search Box -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7">
                    <form action="<?= URL_ROOT ?>/news/search" method="GET" class="input-group search-hub-global rounded-pill overflow-hidden bg-white shadow-lg p-2">
                        <input type="text" name="q" class="form-control border-0 px-4 py-3" placeholder="Bạn muốn tìm hiểu kiến thức gì hôm nay?" required>
                        <button class="btn btn-primary rounded-pill px-5 fw-bold" type="submit">KHÁM PHÁ <i class="bi bi-search ms-2"></i></button>
                    </form>
                    <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
                        <span class="small opacity-50">Xu hướng:</span>
                        <a href="<?= URL_ROOT ?>/news/search?q=ức+gà" class="badge rounded-pill border border-white border-opacity-25 text-white text-decoration-none px-3 py-2 hover-bg-primary transition-small">#EatClean</a>
                        <a href="<?= URL_ROOT ?>/news/search?q=deadlift" class="badge rounded-pill border border-white border-opacity-25 text-white text-decoration-none px-3 py-2 hover-bg-primary transition-small">#Deadlift</a>
                        <a href="<?= URL_ROOT ?>/news/search?q=protein" class="badge rounded-pill border border-white border-opacity-25 text-white text-decoration-none px-3 py-2 hover-bg-primary transition-small">#Protein</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Background Decor -->
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25" style="background-image: url('https://images.unsplash.com/photo-1540497077202-7c8a3999166f?q=80&w=1470&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 0; mix-blend-mode: overlay; pointer-events: none;"></div>
    </section>

    <!-- Category Hub Navigation -->
    <section class="py-4 border-bottom bg-light sticky-top" style="z-index: 1000; top: 70px;">
        <div class="container">
            <div class="d-flex justify-content-center flex-wrap gap-4">
                <a href="<?= URL_ROOT ?>/news" class="nav-hub-link active">Tất cả</a>
                <a href="<?= URL_ROOT ?>/news/category/dinh-duong" class="nav-hub-link">Dinh dưỡng</a>
                <a href="<?= URL_ROOT ?>/news/category/tap-luyen" class="nav-hub-link">Tập luyện</a>
                <a href="<?= URL_ROOT ?>/news/category/success-stories" class="nav-hub-link">Kỳ tích GYMPRO</a>
                <a href="<?= URL_ROOT ?>/news/category/phong-cach-song" class="nav-hub-link">Lối sống lành mạnh</a>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="row g-5">
                <!-- Central News Feed -->
                <div class="col-lg-9 order-1">
                    <?php 
                    $featured = $news_list[0] ?? null; 
                    ?>
                    
                    <!-- Featured Article -->
                    <?php if ($featured): ?>
                    <div class="mb-5 reveal">
                        <a href="<?= URL_ROOT ?>/news/detail/<?= $featured->slug ?>" class="text-decoration-none group">
                            <div class="news-featured-card-v2 overflow-hidden position-relative rounded-5" style="height: 500px;">
                                <img src="<?= htmlspecialchars($featured->image) ?>" class="w-100 h-100 object-fit-cover transition-medium group-hover-scale" alt="Featured">
                                <div class="news-featured-overlay-v2 p-5 d-flex flex-column justify-content-end">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <span class="badge bg-primary px-3 py-2 rounded-pill"><?= htmlspecialchars($featured->category) ?></span>
                                        <span class="text-white small fw-bold"><i class="bi bi-star-fill text-warning me-1"></i> BÀI VIẾT TIÊU BIỂU</span>
                                    </div>
                                    <h2 class="display-4 fw-800 text-white mb-3" style="line-height: 1.1;"><?= htmlspecialchars($featured->title) ?></h2>
                                    <p class="lead text-white-50 opacity-100 mb-0 line-clamp-2"><?= htmlspecialchars($featured->summary) ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>

                    <!-- News Grid -->
                    <div class="row g-4 reveal" id="newsGrid">
                        <?php 
                        $count = 0;
                        foreach ($news_list as $news): 
                            if($featured && $news->id == $featured->id) continue;
                            $count++;
                            $isHidden = $count > 2 ? 'd-none news-hidden' : '';
                        ?>
                        <div class="col-md-6 news-item <?= $isHidden ?>" data-category="<?= htmlspecialchars($news->category) ?>">
                            <div class="news-card-magazine h-100 border-0 transition-medium hover-lift">
                                <div class="img-wrapper position-relative overflow-hidden mb-3 shadow-sm rounded-4" style="height: 250px;">
                                    <img src="<?= htmlspecialchars($news->image) ?>" alt="<?= htmlspecialchars($news->title) ?>" class="w-100 h-100 object-fit-cover transition-medium hover-scale">
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="glass-pill px-3 py-2 text-white small fw-bold"><?= htmlspecialchars($news->category) ?></span>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="d-flex align-items-center gap-3 mb-2 text-muted" style="font-size: 0.75rem;">
                                        <span class="fw-bold text-dark text-uppercase"><?= htmlspecialchars($news->author) ?></span>
                                        <span>•</span>
                                        <span><?= date('d/m/Y', strtotime($news->created_at)) ?></span>
                                    </div>
                                    <h5 class="fw-800 text-dark mb-3 line-clamp-2 h-auto" style="min-height: 3rem; line-height: 1.4;">
                                        <a href="<?= URL_ROOT ?>/news/detail/<?= $news->slug ?>" class="text-decoration-none text-dark hover-primary"><?= htmlspecialchars($news->title) ?></a>
                                    </h5>
                                    <p class="text-muted small mb-0 line-clamp-3" style="line-height: 1.6;"><?= htmlspecialchars($news->summary) ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Load More Button -->
                    <?php if ($count > 2): ?>
                    <div class="text-center mt-5 reveal" id="loadMoreContainer">
                        <button id="loadMoreBtn" class="btn btn-outline-dark rounded-pill px-5 py-3 fw-bold transition-medium hover-bg-dark">TẢI THÊM BÀI VIẾT <i class="bi bi-plus-lg ms-2"></i></button>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Right Sidebar (Desktop Only) -->
                <div class="col-lg-3 d-none d-lg-block order-2">
                    <div class="sticky-top" style="top: 150px;">
                        <h5 class="fw-800 mb-4 border-start border-primary border-4 ps-3 text-uppercase">Xu hướng</h5>
                        <?php if(isset($trending_news) && !empty($trending_news)): ?>
                            <div class="d-grid gap-4">
                                <?php foreach($trending_news as $tnews): ?>
                                    <div class="trending-mini-card group">
                                        <a href="<?= URL_ROOT ?>/news/detail/<?= $tnews->slug ?>" class="text-decoration-none d-flex gap-3">
                                            <div class="flex-shrink-0" style="width: 70px; height: 70px;">
                                                <img src="<?= htmlspecialchars($tnews->image) ?>" class="w-100 h-100 rounded-3 object-fit-cover shadow-sm grayscale-hover transition-medium" alt="trend">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="text-dark fw-bold mb-1 small line-clamp-2" style="font-size: 0.8rem; line-height: 1.4;"><?= htmlspecialchars($tnews->title) ?></h6>
                                                <span class="text-primary-light fw-bold text-uppercase" style="font-size: 0.6rem; letter-spacing: 1px;"><?= $tnews->category ?></span>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Premium Support -->
                        <div class="mt-5 p-4 rounded-4 bg-light shadow-sm reveal">
                            <i class="bi bi-headset fs-2 text-primary mb-3 d-block"></i>
                            <h6 class="fw-bold">Hỗ trợ cá nhân?</h6>
                            <p class="small text-muted mb-3">Đội ngũ HLV GymPro luôn sẵn sàng giải đáp thắc mắc tập luyện của bạn qua hotline 24/7.</p>
                            <a href="#" class="btn btn-outline-dark btn-sm w-100 rounded-pill fw-bold">1900 888 666</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Premium Success Section -->
    <section class="py-5 bg-light reveal">
        <div class="container py-5">
            <div class="glass-card p-0 rounded-5 overflow-hidden shadow-2xl border-0">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-6">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=1470&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" style="min-height: 400px;" alt="success">
                    </div>
                    <div class="col-lg-6 p-5">
                        <span class="text-primary fw-800 small-caps mb-3 d-block">Success Story</span>
                        <h2 class="display-4 fw-800 mb-4" style="line-height: 1.1;">Lột xác ngoạn mục cùng GymPro</h2>
                        <p class="lead text-muted mb-4 italic">"12 tháng kiên trì tại GymPro đã thay đổi hoàn toàn sức khỏe và sự tự tin của tôi. Đây không chỉ là nơi tập luyện, đây còn là người bạn đồng hành của tôi."</p>
                        <hr class="w-25 border-primary border-4 mb-4">
                        <h5 class="fw-bold mb-1">Trần Nam</h5>
                        <p class="text-muted small mb-4">Hội viên 2 năm - Giảm 23kg mỡ thừa</p>
                        <a href="<?= URL_ROOT ?>/news/category/success-stories" class="btn btn-primary rounded-pill px-4 fw-bold shadow-glow">Xem hàng trăm câu chuyện khác</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.search-hub-global .form-control:focus { box-shadow: none !important; }
.nav-hub-link { font-weight: 700; color: #64748b; text-decoration: none; padding: 0.5rem 1rem; border-radius: 2rem; transition: all 0.3s ease; position: relative; }
.nav-hub-link:hover { color: var(--primary); background: #fff; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
.nav-hub-link.active { color: var(--primary); background: #fff; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1); }
.news-featured-overlay-v2 { position: absolute; bottom: 0; left: 0; width: 100%; background: linear-gradient(0deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0) 100%); transition: all 0.5s ease; }
.group-hover-scale { transition: transform 0.8s ease; }
.group:hover .group-hover-scale { transform: scale(1.1); }
.news-card-magazine { background: transparent; }
.hover-bg-primary:hover { background-color: var(--primary) !important; border-color: var(--primary) !important; opacity: 1 !important; }
.hover-bg-dark:hover { background-color: #000; color: #fff; }
.glass-pill { background: rgba(0,0,0,0.3); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.1); border-radius: 2rem; }
.grayscale-hover { filter: grayscale(100%); opacity: 0.8; }
.trending-mini-card:hover .grayscale-hover { filter: grayscale(0%); opacity: 1; }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reveals = document.querySelectorAll('.reveal, .scale-up');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });
    reveals.forEach(reveal => revealObserver.observe(reveal));

    // Load More Logic
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const hiddenItems = document.querySelectorAll('.news-hidden');
    
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            hiddenItems.forEach(item => {
                item.classList.remove('d-none');
                // Re-observe for animation
                revealObserver.observe(item);
            });
            document.getElementById('loadMoreContainer').classList.add('d-none');
        });
    }
});
</script>

<?php require_once APP_ROOT . '/app/views/layouts/public_footer.php'; ?>
