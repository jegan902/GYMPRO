<!-- Notifications -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Thông báo</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem"><?= $unread ?> chưa đọc</p>
    </div>
    <div class="d-flex gap-2">
        <?php if ($unread > 0): ?>
        <a href="<?= URL_ROOT ?>/notification/readAll" class="btn btn-outline-secondary btn-sm"><i class="bi bi-check-all me-1"></i>Đánh dấu tất cả</a>
        <?php endif; ?>
        <?php if (Session::userRole() === 'admin'): ?>
        <a href="<?= URL_ROOT ?>/notification/create" class="btn btn-primary btn-sm"><i class="bi bi-megaphone me-1"></i>Gửi thông báo</a>
        <?php endif; ?>
    </div>
</div>

<?php
    $typeIcons = ['expiry' => 'bi-exclamation-triangle text-warning', 'reminder' => 'bi-bell text-info', 'system' => 'bi-gear text-primary', 'promotion' => 'bi-gift text-success'];
?>

<?php if (!empty($notifications)): ?>
<div class="card card-custom">
    <?php foreach ($notifications as $n): ?>
    <a href="<?= URL_ROOT ?>/notification/read/<?= $n->id ?>" class="d-flex align-items-start gap-3 p-3 text-decoration-none"
       style="border-bottom:1px solid var(--border-color); <?= !$n->is_read ? 'background:rgba(108,99,255,0.04)' : '' ?>">
        <i class="bi <?= $typeIcons[$n->type] ?? 'bi-info-circle text-muted' ?>" style="font-size:1.2rem;margin-top:2px"></i>
        <div class="flex-grow-1">
            <div class="d-flex justify-content-between">
                <strong style="color:var(--text-primary);font-size:0.9rem"><?= htmlspecialchars($n->title) ?></strong>
                <small class="text-muted"><?= date('d/m H:i', strtotime($n->created_at)) ?></small>
            </div>
            <p class="text-muted mb-0" style="font-size:0.8rem"><?= htmlspecialchars($n->message) ?></p>
        </div>
        <?php if (!$n->is_read): ?>
            <span class="badge bg-primary" style="font-size:0.55rem;padding:4px 6px">Mới</span>
        <?php endif; ?>
    </a>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="card card-custom">
    <div class="card-body text-center text-muted py-5">
        <i class="bi bi-bell-slash display-4 d-block mb-2"></i>Không có thông báo
    </div>
</div>
<?php endif; ?>
