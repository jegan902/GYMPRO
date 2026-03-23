<?php require_once APP_ROOT . '/app/views/layouts/main.php'; ?>

<div class="p-4">
    <div class="mb-4 reveal">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= URL_ROOT ?>/news/admin_index" class="text-decoration-none">Quản lý Tin tức</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thêm bài viết mới</li>
            </ol>
        </nav>
        <h2 class="fw-800">Tạo Bài Viết Mới</h2>
    </div>

    <form action="<?= URL_ROOT ?>/news/store" method="POST">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="glass-card border-0 shadow-sm rounded-4 p-4 reveal">
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Tiêu đề bài viết</label>
                        <input type="text" name="title" id="title" class="form-control form-control-lg rounded-3 border-light-subtle shadow-sm" placeholder="Nhập tiêu đề hấp dẫn..." required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Đường dẫn thân thiện (Slug)</label>
                        <div class="input-group shadow-sm rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-light-subtle text-muted small">/news/detail/</span>
                            <input type="text" name="slug" id="slug" class="form-control border-light-subtle" placeholder="tieu-de-bai-viet" required>
                        </div>
                        <small class="text-muted mt-1 d-block"><i class="bi bi-info-circle me-1"></i> Tự động tạo từ tiêu đề nếu để trống.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Tóm tắt ngắn</label>
                        <textarea name="summary" class="form-control rounded-3 border-light-subtle shadow-sm" rows="3" placeholder="Mô tả ngắn gọn nội dung bài viết (hiển thị ở trang danh sách)..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Nội dung bài viết (HTML)</label>
                        <textarea name="content" class="form-control rounded-3 border-light-subtle shadow-sm" rows="15" placeholder="Sử dụng thẻ <p>, <h4>, <ul> để định dạng nội dung..." required></textarea>
                    </div>

                    <div class="d-flex gap-2 justify-content-end pt-3">
                        <a href="<?= URL_ROOT ?>/news/admin_index" class="btn btn-light rounded-pill px-4">HỦY BỎ</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">XUẤT BẢN NGAY <i class="bi bi-send ms-2"></i></button>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <!-- Settings Card -->
                    <div class="glass-card border-0 shadow-sm rounded-4 p-4 mb-4 reveal">
                        <h5 class="fw-bold mb-4 border-start border-primary border-4 ps-3">Cấu hình bài viết</h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Chuyên mục</label>
                            <select name="category" class="form-select rounded-3 border-light-subtle">
                                <option value="Dinh Dưỡng">Dinh Dưỡng</option>
                                <option value="Tập Luyện">Tập Luyện</option>
                                <option value="Kỳ tích GYMPRO">Kỳ tích GYMPRO</option>
                                <option value="Phong cách sống">Phong cách sống</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Ảnh bìa (URL)</label>
                            <input type="text" name="image" id="imageUrl" class="form-control rounded-3 border-light-subtle" placeholder="https://example.com/image.jpg" required>
                            <div class="mt-3 text-center p-3 bg-light rounded-3 border border-dashed text-muted overflow-hidden" style="max-height: 200px;">
                                <img id="imagePreview" src="" class="img-fluid rounded d-none" alt="preview">
                                <div id="imagePlaceholder">
                                    <i class="bi bi-image display-6 opacity-25"></i>
                                    <p class="small mb-0 mt-2 italic">Xem trước ảnh</p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 opacity-10">

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="isFeatured">
                            <label class="form-check-label fw-semibold" for="isFeatured">Bài viết Nổi bật</label>
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="is_trending" id="isTrending">
                            <label class="form-check-label fw-semibold" for="isTrending">Xu hướng (Trending)</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    let title = this.value;
    let slug = title.toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/[đĐ]/g, 'd')
        .replace(/([^0-9a-z-\s])/g, '')
        .replace(/(\s+)/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('slug').value = slug;
});

// Image preview
document.getElementById('imageUrl').addEventListener('input', function() {
    const url = this.value;
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('imagePlaceholder');
    if (url) {
        preview.src = url;
        preview.classList.remove('d-none');
        placeholder.classList.add('d-none');
    } else {
        preview.classList.add('d-none');
        placeholder.classList.remove('d-none');
    }
});
</script>
