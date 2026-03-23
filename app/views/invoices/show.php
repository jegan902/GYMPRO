<!-- Invoice Detail -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Hóa đơn #<?= $invoice->id ?></h4>
    <a href="<?= URL_ROOT ?>/invoice" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-xl-8">
        <div class="card card-custom">
            <div class="card-body p-4">
                <!-- Invoice Header -->
                <div class="d-flex justify-content-between align-items-start mb-4 pb-4" style="border-bottom:1px solid var(--border-color)">
                    <div>
                        <h4 class="mb-1" style="color:var(--primary)"><i class="bi bi-lightning-charge-fill me-2"></i>GYMPRO</h4>
                        <p class="text-muted mb-0" style="font-size:0.85rem">Hóa đơn thanh toán</p>
                    </div>
                    <div class="text-end">
                        <span class="status-badge status-<?= $invoice->status ?>" style="font-size:0.85rem;padding:6px 14px">
                            <?= ucfirst($invoice->status) ?>
                        </span>
                        <p class="text-muted mt-2 mb-0" style="font-size:0.8rem">
                            #INV-<?= str_pad($invoice->id, 6, '0', STR_PAD_LEFT) ?>
                        </p>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:1px">THÀNH VIÊN</h6>
                        <p class="mb-1"><strong><?= htmlspecialchars($invoice->member_name) ?></strong></p>
                        <p class="text-muted mb-0" style="font-size:0.85rem"><?= htmlspecialchars($invoice->member_email) ?></p>
                        <?php if ($invoice->member_phone): ?>
                            <p class="text-muted mb-0" style="font-size:0.85rem"><?= htmlspecialchars($invoice->member_phone) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h6 class="text-muted mb-2" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:1px">THÔNG TIN</h6>
                        <p class="mb-1" style="font-size:0.85rem">
                            <strong>Ngày:</strong> <?= $invoice->payment_date ? date('d/m/Y H:i', strtotime($invoice->payment_date)) : '—' ?>
                        </p>
                        <p class="mb-0" style="font-size:0.85rem">
                            <strong>Phương thức:</strong> <?= ucfirst($invoice->payment_method) ?>
                        </p>
                        <?php if ($invoice->transaction_id): ?>
                            <p class="mb-0" style="font-size:0.85rem">
                                <strong>Mã GD:</strong> <?= htmlspecialchars($invoice->transaction_id) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Items -->
                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>Mô tả</th>
                                <th>Thời hạn</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($invoice->package_name ?? 'Dịch vụ khác') ?></strong>
                                </td>
                                <td><?= $invoice->package_duration ? $invoice->package_duration . ' ngày' : '—' ?></td>
                                <td class="text-end" style="font-weight:700"><?= number_format($invoice->amount, 0, ',', '.') ?>₫</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end"><strong>TỔNG CỘNG</strong></td>
                                <td class="text-end" style="font-size:1.2rem;font-weight:800;color:var(--primary)"><?= number_format($invoice->amount, 0, ',', '.') ?>₫</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <?php if ($invoice->notes): ?>
                <div class="mt-3 p-3" style="background:var(--bg-input);border-radius:var(--radius-sm)">
                    <strong style="font-size:0.8rem">Ghi chú:</strong>
                    <p class="mb-0 mt-1" style="font-size:0.85rem"><?= htmlspecialchars($invoice->notes) ?></p>
                </div>
                <?php endif; ?>

                <!-- Actions -->
                <?php if ($invoice->status === 'pending'): ?>
                <div class="mt-4 d-flex gap-2">
                    <form method="POST" action="<?= URL_ROOT ?>/invoice/updateStatus/<?= $invoice->id ?>">
                        <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
                        <input type="hidden" name="status" value="paid">
                        <button class="btn btn-success"><i class="bi bi-check-lg me-2"></i>Xác nhận thanh toán</button>
                    </form>
                    <form method="POST" action="<?= URL_ROOT ?>/invoice/updateStatus/<?= $invoice->id ?>">
                        <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
                        <input type="hidden" name="status" value="cancelled">
                        <button class="btn btn-outline-danger"><i class="bi bi-x-lg me-2"></i>Hủy</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
