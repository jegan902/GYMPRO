<!-- Exercises List -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Bài tập</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Thư viện bài tập theo nhóm cơ</p>
    </div>
    <?php if (in_array(Session::userRole(), ['admin', 'staff'])): ?>
    <a href="<?= URL_ROOT ?>/exercise/create" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Thêm bài tập</a>
    <?php endif; ?>
</div>

<!-- Search -->
<div class="card card-custom mb-4">
    <div class="card-body py-3">
        <form method="GET" action="<?= URL_ROOT ?>/exercise" class="d-flex gap-3">
            <input type="text" name="search" class="form-control" placeholder="Tìm bài tập, nhóm cơ..." value="<?= htmlspecialchars($search) ?>" style="max-width:400px">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
            <?php if ($search): ?><a href="<?= URL_ROOT ?>/exercise" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a><?php endif; ?>
        </form>
    </div>
</div>

<!-- Exercises grid by muscle group -->
<?php
    $grouped = [];
    foreach ($exercises as $ex) {
        $mg = $ex->muscle_group_vi ?? $ex->muscle_group_name ?? 'Khác';
        $grouped[$mg][] = $ex;
    }
?>

<?php if (!empty($grouped)): ?>
    <?php foreach ($grouped as $group => $exList): ?>
    <div class="mb-4">
        <h5 class="mb-3" style="color:var(--primary);font-weight:700">
            <i class="bi bi-lightning-charge me-2"></i><?= htmlspecialchars($group) ?>
            <span class="badge bg-secondary ms-2" style="font-size:0.7rem"><?= count($exList) ?></span>
        </h5>
        <div class="row g-3">
            <?php foreach ($exList as $ex): ?>
            <div class="col-xl-4 col-md-6">
                <div class="card card-custom h-100 exercise-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-0"><?= htmlspecialchars($ex->name) ?></h6>
                            <span class="badge bg-<?= $ex->level === 'beginner' ? 'success' : ($ex->level === 'advanced' ? 'danger' : 'warning') ?>" style="font-size:0.65rem">
                                <?= ucfirst($ex->level ?? 'beginner') ?>
                            </span>
                        </div>
                        <p class="text-muted mb-2" style="font-size:0.8rem"><?= htmlspecialchars($ex->description ?? '') ?></p>
                        <div class="d-flex gap-2 mb-2" style="font-size:0.75rem">
                            <?php if ($hasPT): ?>
                            <span class="text-muted"><i class="bi bi-layers me-1"></i><?= $ex->sets_recommended ?? 3 ?> sets</span>
                            <span class="text-muted"><i class="bi bi-arrow-repeat me-1"></i><?= htmlspecialchars($ex->reps_recommended ?? '10-12') ?> reps</span>
                            <?php endif; ?>
                            <?php if (!empty($ex->equipment)): ?>
                            <span class="text-muted"><i class="bi bi-tools me-1"></i><?= htmlspecialchars($ex->equipment) ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if ($hasPT): ?>
                            <?php if (!empty($ex->video_url)): ?>
                                <a href="<?= htmlspecialchars($ex->video_url) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-play-circle me-1"></i>Video
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="alert alert-warning py-1 px-2 mb-0 mt-2 d-inline-block" style="font-size:0.75rem">
                                🔒 Chỉ dành cho gói PT
                            </div>
                        <?php endif; ?>
                        <?php if (in_array(Session::userRole(), ['admin', 'staff'])): ?>
                        <div class="d-flex gap-1 mt-2">
                            <a href="<?= URL_ROOT ?>/exercise/edit/<?= $ex->id ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <a href="<?= URL_ROOT ?>/exercise/delete/<?= $ex->id ?>" class="btn btn-sm btn-outline-danger" data-confirm="Xóa bài tập này?"><i class="bi bi-trash"></i></a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="text-center text-muted py-5">
        <i class="bi bi-activity display-4 d-block mb-2"></i>
        Chưa có bài tập nào
    </div>
<?php endif; ?>

<style>
.exercise-card { transition: var(--transition); }
.exercise-card:hover { transform: translateY(-2px); box-shadow: var(--shadow); }
</style>
