<?php require_once APP_ROOT . '/app/views/layouts/main.php'; ?>

<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 reveal">
        <div>
            <h2 class="fw-800 mb-1">Quản lý Tin tức</h2>
            <p class="text-muted mb-0">Danh sách các bài viết trên hệ thống GymPro</p>
        </div>
        <a href="<?= URL_ROOT ?>/news/create" class="btn btn-primary rounded-pill px-4 shadow-sm hover-lift">
            <i class="bi bi-plus-lg me-2"></i> THÊM BÀI VIẾT
        </a>
    </div>

    <?php if (Session::get('news_msg')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= Session::flash('news_msg') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="glass-card border-0 shadow-sm rounded-4 overflow-hidden reveal">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 80px;">ID</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Bài viết</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Chuyên mục</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Tác giả</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Trạng thái</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($news)): ?>
                        <?php foreach ($news as $article): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $article->id ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 overflow-hidden" style="width: 50px; height: 50px;">
                                            <img src="<?= htmlspecialchars($article->image) ?>" class="w-100 h-100 object-fit-cover" alt="thumb">
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold line-clamp-1"><?= htmlspecialchars($article->title) ?></h6>
                                            <small class="text-muted italic"><?= date('d/m/Y', strtotime($article->created_at)) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-primary rounded-pill border px-3"><?= htmlspecialchars($article->category) ?></span>
                                </td>
                                <td>
                                    <span class="small fw-semibold text-dark"><?= htmlspecialchars($article->author) ?></span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <?php if ($article->is_featured): ?>
                                            <span class="badge bg-warning text-dark rounded-pill shadow-sm" title="Nổi bật"><i class="bi bi-star-fill"></i></span>
                                        <?php endif; ?>
                                        <?php if ($article->is_trending): ?>
                                            <span class="badge bg-danger text-white rounded-pill shadow-sm" title="Xu hướng"><i class="bi bi-graph-up-arrow"></i></span>
                                        <?php endif; ?>
                                        <?php if (!$article->is_featured && !$article->is_trending): ?>
                                            <span class="badge bg-info text-white rounded-pill shadow-sm" title="Thường"><i class="bi bi-journal-text"></i></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-sm rounded-pill overflow-hidden bg-white">
                                        <a href="<?= URL_ROOT ?>/news/detail/<?= $article->slug ?>" target="_blank" class="btn btn-sm btn-outline-light border-0 text-primary px-3" title="Xem trước">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= URL_ROOT ?>/news/edit/<?= $article->id ?>" class="btn btn-sm btn-outline-light border-0 text-warning px-3" title="Chỉnh sửa">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-light border-0 text-danger px-3" title="Xóa" onclick="confirmDelete(<?= $article->id ?>)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-journal-x display-4 text-muted opacity-25 mb-3"></i>
                                <p class="text-muted">Chưa có bài viết nào được đăng.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('Bạn có chắc chắn muốn xóa bài viết này? Hành động này không thể hoàn tác.')) {
        window.location.href = '<?= URL_ROOT ?>/news/delete/' + id;
    }
}
</script>

<style>
.line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
.btn-outline-light:hover { background-color: #f8f9fa !important; }
</style>
