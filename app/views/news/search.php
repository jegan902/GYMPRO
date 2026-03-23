<?php require_once APP_ROOT . '/app/views/layouts/public_header.php'; ?>

<main class="bg-white overflow-hidden">
    <!-- Search Header -->
    <section class="py-5 bg-light position-relative">
        <div class="container py-5 text-center reveal">
            <h1 class="fw-800 display-4 mb-4 font-heading">Kết quả tìm kiếm</h1>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <form action="<?= URL_ROOT ?>/news/search" method="GET" class="input-group search-hub-input rounded-pill overflow-hidden bg-white shadow-sm p-1">
                        <input type="text" name="q" class="form-control border-0 px-4 py-3" placeholder="Tìm kiếm kiến thức..." value="<?= htmlspecialchars($query) ?>" required>
                        <button class="btn btn-primary rounded-pill px-4 py-3" type="submit"><i class="bi bi-search me-2"></i> TÌM KIẾM</button>
                    </form>
                    <p class="mt-4 text-muted">
                        Tìm thấy <span class="fw-bold text-dark"><?= count($results) ?></span> kết quả cho từ khóa "<span class="italic"><?= htmlspecialchars($query) ?></span>"
                    </p>
                </div>
            </div>
        </div>
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25" style="z-index: 0; background-image: radial-gradient(var(--primary-light) 1px, transparent 1px); background-size: 20px 20px;"></div>
    </section>

    <!-- Results Section -->
    <section class="py-5">
        <div class="container py-5">
            <div class="row g-5">
                <!-- Search Results -->
                <div class="col-lg-8">
                    <?php if (!empty($results)): ?>
                        <div class="row g-4">
                            <?php foreach ($results as $news): ?>
                                <div class="col-12 reveal">
                                    <div class="news-card-search d-flex gap-4 p-4 rounded-4 border hover-lift transition-medium">
                                        <div class="flex-shrink-0 d-none d-md-block" style="width: 200px; height: 150px;">
                                            <img src="<?= htmlspecialchars($news->image) ?>" alt="<?= htmlspecialchars($news->title) ?>" class="w-100 h-100 rounded-3 object-fit-cover">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <span class="badge bg-primary-light text-primary rounded-pill small px-2 py-1"><?= htmlspecialchars($news->category) ?></span>
                                                <span class="text-muted small"><?= date('d/m/Y', strtotime($news->created_at)) ?></span>
                                            </div>
                                            <h4 class="fw-bold mb-2">
                                                <a href="<?= URL_ROOT ?>/news/detail/<?= $news->slug ?>" class="text-dark text-decoration-none hover-primary"><?= htmlspecialchars($news->title) ?></a>
                                            </h4>
                                            <p class="text-muted small mb-0 line-clamp-2"><?= htmlspecialchars($news->summary) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 bg-light rounded-5 reveal">
                            <i class="bi bi-emoji-frown display-1 text-muted opacity-25 mb-4"></i>
                            <h3 class="fw-bold">Rất tiếc, không tìm thấy kết quả</h3>
                            <p class="text-muted mx-auto" style="max-width: 400px;">Hãy thử tìm kiếm bằng từ khóa khác hoặc quay lại xem các chuyên mục phổ biến nhé!</p>
                            <a href="<?= URL_ROOT ?>/news" class="btn btn-outline-primary rounded-pill px-4 mt-3">Tất cả bài viết</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Trending Sidebar -->
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
                                <a href="<?= URL_ROOT ?>/news/category/<?= $cat_slug ?>" class="category-link">
                                    <?= $cat_name ?> 
                                    <span class="badge bg-light text-muted ms-auto rounded-pill border"><?= $count ?></span>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="glass-card p-4 rounded-4 shadow-sm border-0 reveal">
                            <h5 class="fw-bold mb-4 border-start border-primary border-4 ps-3">Bài viết mới nhất</h5>
                            <?php if(isset($recent_posts)): ?>
                                <div class="row g-4">
                                    <?php foreach($recent_posts as $rnews): ?>
                                        <div class="col-12">
                                            <a href="<?= URL_ROOT ?>/news/detail/<?= $rnews->slug ?>" class="text-decoration-none d-flex gap-3 align-items-center group">
                                                <div class="flex-shrink-0" style="width: 50px; height: 50px;">
                                                    <img src="<?= htmlspecialchars($rnews->image) ?>" class="w-100 h-100 rounded-circle object-fit-cover shadow-sm transition-medium group-hover-translate-y" alt="trend">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="text-dark fw-bold mb-0 small line-clamp-2" style="font-size: 0.8rem;"><?= htmlspecialchars($rnews->title) ?></h6>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
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
.search-hub-input .form-control:focus { box-shadow: none !important; }
.category-link { display: flex; align-items: center; padding: 0.75rem 1rem; border-radius: 0.75rem; color: #475569; text-decoration: none; font-weight: 600; transition: all 0.3s ease; border: 1px solid transparent; font-size: 0.9rem; }
.category-link:hover { background: white; border-color: #f1f5f9; color: var(--primary); transform: translateX(5px); box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
.news-card-search { background: white; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
.news-card-search:hover { border-color: var(--primary) !important; background: #fdfaf8; }
.group-hover-translate-y:hover { transform: translateY(-3px); }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>

<?php require_once APP_ROOT . '/app/views/layouts/public_footer.php'; ?>
