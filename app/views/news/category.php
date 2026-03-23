<?php require_once APP_ROOT . '/app/views/layouts/public_header.php'; ?>

<main class="bg-white overflow-hidden">
    <!-- Category Header -->
    <section class="py-5 bg-dark text-white position-relative overflow-hidden">
        <div class="container py-5 text-center reveal">
            <span class="badge bg-primary px-3 py-2 rounded-pill mb-3 text-uppercase fw-bold" style="letter-spacing: 2px;">CHUYÊN MỤC</span>
            <h1 class="fw-800 display-3 mb-3 font-heading text-white"><?= htmlspecialchars($category) ?></h1>
            <p class="lead opacity-75 mx-auto" style="max-width: 700px;">
                Khám phá những kiến thức chuyên sâu và bí quyết độc quyền về <?= htmlspecialchars($category) ?> từ đội ngũ chuyên gia GymPro.
            </p>
        </div>
        <div class="position-absolute bottom-0 start-0 w-100 h-100 opacity-10" style="background-image: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1470&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 0;"></div>
    </section>

    <!-- Content Section -->
    <section class="py-5">
        <div class="container py-5">
            <div class="row g-5">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <?php if (!empty($news_list)): ?>
                        <div class="row g-4">
                            <?php foreach ($news_list as $news): ?>
                                <div class="col-12 reveal">
                                    <div class="glass-card hover-lift transition-medium border-0 shadow-sm p-0 overflow-hidden" style="border-radius: 2rem;">
                                        <div class="row g-0">
                                            <div class="col-md-5">
                                                <div class="h-100 overflow-hidden" style="min-height: 250px;">
                                                    <img src="<?= htmlspecialchars($news->image) ?>" alt="<?= htmlspecialchars($news->title) ?>" class="w-100 h-100 object-fit-cover transition-medium hover-scale">
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="p-4 h-100 d-flex flex-column">
                                                    <div class="d-flex align-items-center gap-2 mb-2 text-muted small">
                                                        <i class="bi bi-calendar3 text-primary"></i> <?= date('d/m/Y', strtotime($news->created_at)) ?>
                                                        <span class="mx-2">•</span>
                                                        <i class="bi bi-person text-primary"></i> <?= htmlspecialchars($news->author) ?>
                                                    </div>
                                                    <h3 class="fw-bold mb-3 h4" style="line-height: 1.4;">
                                                        <a href="<?= URL_ROOT ?>/news/detail/<?= $news->slug ?>" class="text-dark text-decoration-none hover-primary transition-small"><?= htmlspecialchars($news->title) ?></a>
                                                    </h3>
                                                    <p class="text-muted mb-4 small line-clamp-3" style="line-height: 1.6;"><?= htmlspecialchars($news->summary) ?></p>
                                                    <div class="mt-auto">
                                                        <a href="<?= URL_ROOT ?>/news/detail/<?= $news->slug ?>" class="text-primary fw-bold text-decoration-none d-inline-flex align-items-center gap-2 group small">
                                                            ĐỌC CHI TIẾT <i class="bi bi-arrow-right transition-small group-hover-translate-x"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-journal-x display-1 text-muted opacity-25 mb-4"></i>
                            <h3 class="fw-bold">Chưa có bài viết nào</h3>
                            <p class="text-muted">Chúng tôi đang cập nhật nội dung cho chuyên mục này. Quay lại sau nhé!</p>
                            <a href="<?= URL_ROOT ?>/news" class="btn btn-primary rounded-pill px-4 mt-3">Quay lại Tin tức</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <!-- Other Categories -->
                        <div class="glass-card p-4 rounded-4 shadow-sm border-0 mb-4 reveal">
                            <h5 class="fw-bold mb-4 border-start border-primary border-4 ps-3">Phân loại khác</h5>
                            <div class="d-flex flex-column gap-2">
                                <?php 
                                $side_cats = [
                                    "Dinh dưỡng" => "dinh-duong",
                                    "Tập luyện" => "tap-luyen",
                                    "Kỳ tích GYMPRO" => "success-stories",
                                    "Lối sống lành mạnh" => "phong-cach-song"
                                ];
                                foreach($side_cats as $cat_name => $cat_slug):
                                    $count = 0;
                                    foreach($category_counts as $cc) {
                                        if($cc->category == $cat_name) {
                                            $count = $cc->count;
                                            break;
                                        }
                                    }
                                ?>
                                <a href="<?= URL_ROOT ?>/news/category/<?= $cat_slug ?>" class="category-link <?= $current_slug == $cat_slug ? 'active' : '' ?>">
                                    <?= $cat_name ?> 
                                    <span class="badge bg-light text-muted ms-auto rounded-pill border"><?= $count ?></span>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Mini Newsletter -->
                        <div class="glass-card p-4 rounded-4 shadow border-0 text-white overflow-hidden reveal" style="background: linear-gradient(135deg, #075985 0%, #0369a1 100%);">
                            <div class="position-relative z-index-2">
                                <h5 class="fw-bold mb-2">Đăng ký bản tin</h5>
                                <p class="small opacity-75 mb-3">Nhận bí quyết từ chuyên gia mỗi sáng thứ Hai hàng tuần qua email.</p>
                                <div class="d-grid gap-2">
                                    <input type="email" class="form-control form-control-sm border-0 bg-white bg-opacity-10 text-white rounded-pill px-3" placeholder="Email của bạn">
                                    <button class="btn btn-primary btn-sm rounded-pill fw-bold">GỬI NGAY <i class="bi bi-send ms-2"></i></button>
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

<style>
.category-link { display: flex; align-items: center; padding: 0.85rem 1.25rem; border-radius: 1rem; color: #475569; text-decoration: none; font-weight: 600; transition: all 0.3s ease; border: 1px solid transparent; }
.category-link:hover { background: white; border-color: #f1f5f9; color: var(--primary); transform: translateX(5px); box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
.category-link.active { background: white; border-color: var(--primary); color: var(--primary); box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1); }
.hover-scale { transition: transform 0.5s ease; }
.hover-scale:hover { transform: scale(1.08); }
.line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.group-hover-translate-x { transition: transform 0.3s ease; }
.group:hover .group-hover-translate-x { transform: translateX(5px); }
</style>

<?php require_once APP_ROOT . '/app/views/layouts/public_footer.php'; ?>
