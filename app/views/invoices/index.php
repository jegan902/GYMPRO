<!-- Invoice List -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Quản lý Hóa đơn</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">
            Doanh thu tháng này: <strong style="color:var(--success)"><?= number_format($totalRevenue, 0, ',', '.') ?>₫</strong>
        </p>
    </div>
    <a href="<?= URL_ROOT ?>/invoice/create" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Tạo hóa đơn
    </a>
</div>

<!-- Filters -->
<div class="card card-custom mb-4">
    <div class="card-body py-3">
        <form method="GET" action="<?= URL_ROOT ?>/invoice" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Tên thành viên, mã giao dịch..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="paid" <?= $status === 'paid' ? 'selected' : '' ?>>Paid</option>
                    <option value="cancelled" <?= $status === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1"></i> Lọc</button>
                <a href="<?= URL_ROOT ?>/invoice" class="btn btn-outline-secondary"><i class="bi bi-x-lg me-1"></i> Xóa lọc</a>
            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card card-custom">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Thành viên</th>
                        <th>Gói tập</th>
                        <th>Số tiền</th>
                        <th>Phương thức</th>
                        <th>Trạng thái</th>
                        <th>Ngày</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($invoices)): ?>
                        <?php foreach ($invoices as $i => $inv): ?>
                        <tr>
                            <td><?= $inv->id ?></td>
                            <td><strong><?= htmlspecialchars($inv->member_name) ?></strong></td>
                            <td><?= htmlspecialchars($inv->package_name ?? '—') ?></td>
                            <td style="font-weight:700;color:var(--primary)"><?= number_format($inv->amount, 0, ',', '.') ?>₫</td>
                            <td>
                                <span class="badge bg-secondary"><?= ucfirst($inv->payment_method) ?></span>
                            </td>
                            <td>
                                <span class="status-badge status-<?= $inv->status ?>">
                                    <?= ucfirst($inv->status) ?>
                                </span>
                            </td>
                            <td><?= $inv->payment_date ? date('d/m/Y', strtotime($inv->payment_date)) : '—' ?></td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="<?= URL_ROOT ?>/invoice/show/<?= $inv->id ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                                    <?php if ($inv->status === 'pending'): ?>
                                    <form method="POST" action="<?= URL_ROOT ?>/invoice/updateStatus/<?= $inv->id ?>" style="display:inline">
                                        <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
                                        <input type="hidden" name="status" value="paid">
                                        <button class="btn btn-sm btn-outline-success" title="Xác nhận thanh toán"><i class="bi bi-check-lg"></i></button>
                                    </form>
                                    <?php endif; ?>
                                    <?php if (Session::userRole() === 'admin'): ?>
                                    <a href="<?= URL_ROOT ?>/invoice/delete/<?= $inv->id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa hóa đơn #<?= $inv->id ?>?')"><i class="bi bi-trash"></i></a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-receipt display-4 d-block mb-2"></i>Chưa có hóa đơn nào
                        </td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
