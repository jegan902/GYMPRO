<!-- Create Invoice -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Tạo hóa đơn mới</h4>
    <a href="<?= URL_ROOT ?>/invoice" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
</div>

<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card card-custom">
            <div class="card-header-custom"><h5><i class="bi bi-receipt me-2"></i>Thông tin hóa đơn</h5></div>
            <div class="card-body">
                <form action="<?= URL_ROOT ?>/invoice/store" method="POST" id="invoiceForm">
                    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Thành viên <span class="text-danger">*</span></label>
                            <select name="member_id" class="form-select" required>
                                <option value="">-- Chọn thành viên --</option>
                                <?php foreach ($members as $m): ?>
                                    <option value="<?= $m->id ?>"><?= htmlspecialchars($m->full_name) ?> (<?= htmlspecialchars($m->email) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gói tập</label>
                            <select name="package_id" class="form-select" id="packageSelect" onchange="updatePrice()">
                                <option value="">-- Không gắn gói tập --</option>
                                <?php foreach ($packages as $p): ?>
                                    <option value="<?= $p->id ?>" data-price="<?= $p->price ?>"><?= htmlspecialchars($p->name) ?> (<?= number_format($p->price, 0, ',', '.') ?>₫ / <?= $p->duration ?> ngày)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Số tiền (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" name="amount" id="amount" class="form-control" required min="0" step="1000">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Phương thức thanh toán</label>
                            <select name="payment_method" class="form-select">
                                <option value="cash">Tiền mặt</option>
                                <option value="transfer">Chuyển khoản</option>
                                <option value="card">Thẻ</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="paid">Đã thanh toán</option>
                                <option value="pending">Chờ thanh toán</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ngày thanh toán</label>
                            <input type="datetime-local" name="payment_date" class="form-control" value="<?= date('Y-m-d\TH:i') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mã giao dịch</label>
                            <input type="text" name="transaction_id" class="form-control" placeholder="Nếu có">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Ghi chú</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-2"></i>Tạo hóa đơn</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function updatePrice() {
    const sel = document.getElementById('packageSelect');
    const opt = sel.options[sel.selectedIndex];
    const price = opt.dataset.price;
    if (price) document.getElementById('amount').value = price;
}
</script>
