<!-- Member: Danh sách gói tập -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Gói tập</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Chọn gói tập phù hợp với bạn</p>
    </div>
</div>

<?php if ($activePackage): ?>
<div class="alert" style="background:linear-gradient(135deg, var(--primary-light), rgba(0,200,83,0.08)); border:1px solid var(--border-active); border-radius:var(--radius);">
    <div class="d-flex align-items-center gap-3">
        <div class="feature-icon gradient-bg-1" style="width:48px;height:48px;border-radius:12px;font-size:1.2rem;">
            <i class="bi bi-box-seam-fill"></i>
        </div>
        <div>
            <strong>Gói hiện tại: <?= htmlspecialchars($activePackage->package_name) ?></strong>
            <div class="text-muted" style="font-size:0.85rem">
                <i class="bi bi-calendar-event me-1"></i>
                <?php if ($activePackage->start_date): ?>
                    <?= date('d/m/Y', strtotime($activePackage->start_date)) ?> → <?= date('d/m/Y', strtotime($activePackage->end_date)) ?>
                <?php else: ?>
                    Chờ kích hoạt
                <?php endif; ?>
                &nbsp;•&nbsp;
                <span class="status-badge status-<?= $activePackage->status ?>"><?= ucfirst($activePackage->status) ?></span>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row g-4">
    <?php if (!empty($packages)): ?>
        <?php foreach ($packages as $pkg): ?>
        <div class="col-xl-3 col-md-6">
            <div class="card card-custom h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="feature-icon gradient-bg-1" style="width:48px;height:48px;border-radius:12px;font-size:1.2rem;">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>
                    </div>
                    <h5 class="mb-1"><?= htmlspecialchars($pkg->name) ?></h5>
                    <div class="mb-2">
                        <span style="font-size:1.5rem;font-weight:800;color:var(--primary)"><?= number_format($pkg->price, 0, ',', '.') ?></span>
                        <span class="text-muted">₫</span>
                    </div>
                    <p class="text-muted mb-2" style="font-size:0.85rem">
                        <i class="bi bi-calendar3 me-1"></i><?= $pkg->duration ?> ngày
                    </p>
                    <p class="text-muted mb-3" style="font-size:0.8rem;flex:1"><?= htmlspecialchars($pkg->description ?? '') ?></p>

                    <?php if (!empty($pkg->features)): ?>
                    <div class="mb-3">
                        <?php foreach (explode(',', $pkg->features) as $f): ?>
                            <div style="font-size:0.8rem;padding:2px 0;color:var(--text-secondary)">
                                <i class="bi bi-check-circle-fill text-success me-1"></i><?= trim($f) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($activePackage): ?>
                        <button class="btn btn-sm btn-outline-secondary mt-auto" disabled>
                            <i class="bi bi-check-lg me-1"></i>Đang có gói
                        </button>
                    <?php else: ?>
                        <a href="<?= URL_ROOT ?>/package/show/<?= $pkg->id ?>" class="btn btn-primary btn-sm w-100 mt-auto">
                            <i class="bi bi-cart-plus me-1"></i>Đăng ký ngay
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center text-muted py-5">
            <i class="bi bi-box display-4 d-block mb-2"></i>Chưa có gói tập nào
        </div>
    <?php endif; ?>
</div>
