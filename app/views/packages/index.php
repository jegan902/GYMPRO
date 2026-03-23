<!-- Packages List -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Quản lý Gói tập</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Các gói tập luyện phòng gym</p>
    </div>
    <?php if (Session::userRole() === 'admin'): ?>
    <a href="<?= URL_ROOT ?>/package/create" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Thêm gói tập
    </a>
    <?php endif; ?>
</div>

<div class="row g-4">
    <?php if (!empty($packages)): ?>
        <?php foreach ($packages as $pkg): ?>
        <div class="col-xl-3 col-md-6">
            <div class="card card-custom h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="feature-icon <?= $pkg->is_active ? 'gradient-bg-1' : '' ?>" style="width:48px;height:48px;border-radius:12px;font-size:1.2rem;<?= !$pkg->is_active ? 'background:var(--bg-input);color:var(--text-muted);' : '' ?>">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>
                        <span class="status-badge status-<?= $pkg->is_active ? 'active' : 'inactive' ?>">
                            <?= $pkg->is_active ? 'Active' : 'Inactive' ?>
                        </span>
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

                    <?php if (Session::userRole() === 'admin'): ?>
                    <div class="d-flex gap-2 mt-auto">
                        <a href="<?= URL_ROOT ?>/package/edit/<?= $pkg->id ?>" class="btn btn-sm btn-outline-primary flex-fill">
                            <i class="bi bi-pencil me-1"></i>Sửa
                        </a>
                        <a href="<?= URL_ROOT ?>/package/delete/<?= $pkg->id ?>" class="btn btn-sm btn-outline-danger" data-confirm="Xóa gói tập này?">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
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
