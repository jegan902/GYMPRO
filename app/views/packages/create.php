<!-- Create Package -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Thêm gói tập mới</h4>
    <a href="<?= URL_ROOT ?>/package" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
</div>

<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card card-custom">
            <div class="card-header-custom"><h5><i class="bi bi-box-seam me-2"></i>Thông tin gói tập</h5></div>
            <div class="card-body">
                <form action="<?= URL_ROOT ?>/package/store" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tên gói <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Thời hạn (ngày) <span class="text-danger">*</span></label>
                            <input type="number" name="duration" class="form-control" value="30" required min="1">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" required min="0" step="1000">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Quyền lợi (phân cách bằng dấu phẩy)</label>
                            <input type="text" name="features" class="form-control" placeholder="Tập gym tự do, Phòng tắm, Tủ cá nhân">
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                                <label class="form-check-label" for="is_active">Kích hoạt gói tập</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-2"></i>Lưu gói tập</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
