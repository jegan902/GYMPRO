<!-- Edit Equipment -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Sửa thiết bị</h4>
    <a href="<?= URL_ROOT ?>/equipment" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
</div>

<div class="card card-custom">
    <div class="card-body">
        <form action="<?= URL_ROOT ?>/equipment/update/<?= $equipment->id ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tên thiết bị <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($equipment->name) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Loại</label>
                    <select name="category" class="form-select">
                        <?php foreach (['Cardio','Strength','Free Weight','Cable Machine','Other'] as $cat): ?>
                            <option value="<?= $cat ?>" <?= ($equipment->category ?? '') === $cat ? 'selected' : '' ?>><?= $cat === 'Other' ? 'Khác' : $cat ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Số lượng</label>
                    <input type="number" name="quantity" class="form-control" value="<?= $equipment->quantity ?>" min="1">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="active" <?= $equipment->status === 'active' ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="maintenance" <?= $equipment->status === 'maintenance' ? 'selected' : '' ?>>Bảo trì</option>
                        <option value="broken" <?= $equipment->status === 'broken' ? 'selected' : '' ?>>Hỏng</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Ngày mua</label>
                    <input type="date" name="purchase_date" class="form-control" value="<?= $equipment->purchase_date ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Bảo trì gần nhất</label>
                    <input type="date" name="last_maintenance_date" class="form-control" value="<?= $equipment->last_maintenance_date ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Bảo trì tiếp</label>
                    <input type="date" name="next_maintenance_date" class="form-control" value="<?= $equipment->next_maintenance_date ?? '' ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="note" class="form-control" rows="3"><?= htmlspecialchars($equipment->note ?? '') ?></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-2"></i>Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>
