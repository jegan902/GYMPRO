<?php require_once APP_ROOT . '/app/views/layouts/public_header.php'; ?>

<main class="bg-white overflow-hidden">
    <!-- Article Header -->
    <section class="news-detail-header position-relative bg-light">
        <div class="container overflow-visible py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <nav aria-label="breadcrumb" class="mb-4 reveal">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?= URL_ROOT ?>/" class="text-decoration-none">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="<?= URL_ROOT ?>/news" class="text-decoration-none">Tin tức</a></li>
                            <?php 
                                $slug_map = ['Dinh Dưỡng' => 'dinh-duong', 'Tập Luyện' => 'tap-luyen', 'Kỳ tích GYMPRO' => 'success-stories', 'Phong cách sống' => 'phong-cach-song'];
                                $c_slug = $slug_map[$article->category] ?? 'general';
                            ?>
                            <li class="breadcrumb-item"><a href="<?= URL_ROOT ?>/news/category/<?= $c_slug ?>" class="text-decoration-none"><?= htmlspecialchars($article->category) ?></a></li>
                        </ol>
                    </nav>
                    
                    <h1 class="display-3 fw-800 mb-4 reveal" style="line-height: 1.1; letter-spacing: -1px;"><?= htmlspecialchars($article->title) ?></h1>
                    
                    <div class="d-flex align-items-center flex-wrap gap-4 text-muted reveal" style="transition-delay: 0.1s;">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-calendar3 text-primary"></i>
                            <?= date('d/m/Y', strtotime($article->created_at)) ?>
                        </span>
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-person-circle text-primary"></i>
                            <?= htmlspecialchars($article->author ?? 'Admin GymPro') ?>
                        </span>
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-clock text-primary"></i>
                            <?= htmlspecialchars($article->read_time ?? '5 phút') ?> đọc
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25" style="z-index: 0; background-image: radial-gradient(var(--primary-light) 1px, transparent 1px); background-size: 30px 30px;"></div>
    </section>

    <!-- Main Content Body -->
    <section class="py-5" style="margin-top: -3rem;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row g-5">
                        <!-- Article Content -->
                        <div class="col-lg-8 reveal" style="transition-delay: 0.2s;">
                            <!-- Featured Image -->
                            <div class="rounded-5 overflow-hidden shadow-2xl mb-5 scale-up">
                                <img src="<?= htmlspecialchars($article->image) ?>" alt="<?= htmlspecialchars($article->title) ?>" class="w-100" style="max-height: 600px; object-fit: cover;">
                            </div>

                            <!-- Typography Optimized Content -->
                            <article class="news-content-body premium-typography">
                                <?= $article->content ?>
                            </article>

                            <!-- Author Card -->
                            <div class="author-card mt-5 p-4 rounded-4 border-0 shadow-sm reveal" style="background: #f8fafc;">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="author-avatar bg-primary text-white rounded-circle d-grid place-items-center" style="width: 70px; height: 70px; font-size: 1.5rem;">
                                        <i class="bi bi-person-badge"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1"><?= htmlspecialchars($article->author ?? 'Admin GymPro') ?></h5>
                                        <p class="text-muted small mb-0">Chuyên gia tại GYMPRO. Chia sẻ kiến thức khoa học và kinh nghiệm tập luyện thực chiến.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Social Share -->
                            <div class="mt-5 py-4 border-top border-bottom d-flex align-items-center justify-content-between flex-wrap gap-4">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="fw-800 text-uppercase small" style="letter-spacing: 1px;">Chia sẻ:</span>
                                    <div class="d-flex gap-2">
                                        <a href="#" class="social-share-btn"><i class="bi bi-facebook"></i></a>
                                        <a href="#" class="social-share-btn"><i class="bi bi-twitter-x"></i></a>
                                        <a href="#" class="social-share-btn"><i class="bi bi-linkedin"></i></a>
                                        <button class="social-share-btn" onclick="copyURL()"><i class="bi bi-link-45deg"></i></button>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <?php if(isset($article->tags) && is_array($article->tags)): ?>
                                        <?php foreach($article->tags as $tag): ?>
                                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">#<?= $tag ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Comments Placeholder -->
                            <div class="mt-5">
                                <h3 class="fw-800 mb-4 border-start border-primary border-4 ps-3">Thảo luận (2)</h3>
                                <div class="glass-card p-4 rounded-4 shadow-sm border-0 mb-4">
                                    <form id="commentForm">
                                        <div class="mb-3">
                                            <textarea class="form-control rounded-4 px-4 py-3 border-light bg-light focus-shadow-none" rows="4" placeholder="Chia sẻ cảm nghĩ hoặc đặt câu hỏi cho chuyên gia..."></textarea>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-glow">Gửi bình luận <i class="bi bi-send ms-2"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <div class="sticky-top" style="top: 100px;">
                                <!-- Search Sidebar -->
                                <div class="glass-card p-4 rounded-4 shadow-sm border-0 mb-4 reveal">
                                    <h5 class="fw-bold mb-3">Tìm kiếm kiến thức</h5>
                                    <form action="<?= URL_ROOT ?>/news/search" method="GET" class="input-group rounded-pill overflow-hidden bg-light p-1">
                                        <input type="text" name="q" class="form-control border-0 bg-transparent px-3" placeholder="Từ khóa..." required>
                                        <button class="btn btn-primary rounded-pill px-3" type="submit"><i class="bi bi-search"></i></button>
                                    </form>
                                </div>

                                <!-- Related News -->
                                <div class="glass-card p-4 rounded-4 shadow-sm border-0 mb-4 reveal">
                                    <h5 class="fw-bold mb-4 border-start border-primary border-4 ps-3">Bài viết liên quan</h5>
                                    <div class="row g-4">
                                        <?php if (isset($related_news) && !empty($related_news)): ?>
                                            <?php foreach ($related_news as $news): ?>
                                                <div class="col-12 translate-hover transition-medium">
                                                    <a href="<?= URL_ROOT ?>/news/detail/<?= $news->slug ?>" class="text-decoration-none group d-flex gap-3 align-items-center">
                                                        <div class="flex-shrink-0" style="width: 90px; height: 70px;">
                                                            <img src="<?= htmlspecialchars($news->image) ?>" class="w-100 h-100 rounded-3 object-fit-cover shadow-sm grayscale-hover transition-medium" alt="<?= htmlspecialchars($news->title) ?>">
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="text-dark fw-bold mb-1 line-clamp-2 small" style="line-height: 1.4;"><?= htmlspecialchars($news->title) ?></h6>
                                                            <div class="d-flex align-items-center gap-2 text-muted" style="font-size: 0.7rem;">
                                                                <span><i class="bi bi-calendar3 me-1"></i> <?= date('d/m', strtotime($news->created_at)) ?></span>
                                                                <span>•</span>
                                                                <span class="text-primary fw-bold text-uppercase small-caps"><?= $news->category ?></span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p class="text-muted small mb-0">Không có bài viết liên quan trong chuyên mục này.</p>
                                        <?php endif; ?>
                                    </div>
                                    <a href="<?= URL_ROOT ?>/news" class="btn btn-light w-100 mt-4 rounded-pill fw-bold py-2 text-primary transition-small hover-shadow">Tất cả bài viết <i class="bi bi-arrow-right ms-1"></i></a>
                                </div>

                                <!-- Newsletter Box -->
                                <div class="glass-card p-4 rounded-4 shadow border-0 position-relative overflow-hidden reveal text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                                    <div class="position-relative z-index-2 py-2">
                                        <h5 class="fw-bold mb-3">Nhận tin sớm nhất</h5>
                                        <p class="small opacity-75 mb-4">Đồng hành cùng GymPro để nhận giáo án và thực đơn mới nhất mỗi sáng Thứ Hai.</p>
                                        <div class="d-grid gap-2">
                                            <input type="email" class="form-control form-control-sm bg-white bg-opacity-10 border-0 text-white placeholder-white-50 rounded-pill px-3" placeholder="Email của bạn">
                                            <button class="btn btn-primary btn-sm rounded-pill fw-bold">ĐĂNG KÝ <i class="bi bi-send-fill ms-2"></i></button>
                                        </div>
                                    </div>
                                    <i class="bi bi-lightning-charge position-absolute bottom-0 end-0 opacity-10" style="font-size: 8rem; margin: -2rem;"></i>
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
    const reveals = document.querySelectorAll('.reveal, .scale-up');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.1 });
    reveals.forEach(reveal => revealObserver.observe(reveal));
});

function copyURL() {
    navigator.clipboard.writeText(window.location.href);
    alert('Đã sao chép liên kết vào bộ nhớ tạm!');
}
</script>

<style>
.premium-typography h4 { font-weight: 800; margin-top: 2.5rem; margin-bottom: 1.5rem; color: #0f172a; position: relative; }
.premium-typography p { font-size: 1.15rem; line-height: 1.8; color: #334155; margin-bottom: 1.5rem; }
.premium-typography ul, .premium-typography ol { margin-bottom: 2rem; padding-left: 1.5rem; }
.premium-typography li { font-size: 1.15rem; line-height: 1.8; color: #334155; margin-bottom: 0.75rem; }
.social-share-btn { width: 45px; height: 45px; border-radius: 50%; border: 1px solid #e2e8f0; display: grid; place-items: center; color: #64748b; background: white; transition: all 0.3s ease; text-decoration: none; }
.social-share-btn:hover { background: var(--primary); color: white; border-color: var(--primary); transform: translateY(-3px); box-shadow: 0 10px 15px rgba(255, 94, 0, 0.2); }
.translate-hover:hover { transform: translateX(5px); }
.grayscale-hover { filter: grayscale(100%); opacity: 0.8; }
.group:hover .grayscale-hover { filter: grayscale(0%); opacity: 1; }
.small-caps { font-variant: small-caps; letter-spacing: 0.5px; }
.focus-shadow-none:focus { shadow: none !important; border-color: var(--primary) !important; }
</style>

<?php require_once APP_ROOT . '/app/views/layouts/public_footer.php'; ?>
