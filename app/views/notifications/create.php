<!-- Send Notification -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Gửi thông báo</h4>
    <a href="<?= URL_ROOT ?>/notification" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
</div>

<div class="card card-custom">
    <div class="card-body">
        <form action="<?= URL_ROOT ?>/notification/send" method="POST">
            <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required placeholder="VD: Lịch bảo trì phòng gym">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Loại</label>
                    <select name="type" class="form-select">
                        <option value="system">Hệ thống</option>
                        <option value="promotion">Khuyến mãi</option>
                        <option value="reminder">Nhắc nhở</option>
                        <option value="expiry">Hết hạn</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Nội dung <span class="text-danger">*</span></label>
                    <textarea name="message" class="form-control" rows="5" required placeholder="Nội dung thông báo..."></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Gửi đến</label>
                    <select name="target" class="form-select">
                        <option value="all">Tất cả hội viên</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-send me-2"></i>Gửi thông báo</button>
                </div>
            </div>
        </form>
    </div>
</div>
