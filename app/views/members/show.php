<!-- Member Detail -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Chi tiết thành viên</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem"><?= htmlspecialchars($member->full_name) ?></p>
    </div>
    <div class="d-flex gap-2">
        <?php if ($member->role === 'user'): ?>
            <form action="<?= URL_ROOT ?>/member/grant/<?= $member->id ?>" method="POST" class="d-inline">
                <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
                <button type="submit" class="btn btn-success" onclick="return confirm('Cấp quyền truy cập Hệ thống trợ lý cho tài khoản này?')">
                    <i class="bi bi-shield-check me-2"></i>Cấp quyền Hội viên
                </button>
            </form>
        <?php endif; ?>
        <a href="<?= URL_ROOT ?>/member/edit/<?= $member->id ?>" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Sửa
        </a>
        <a href="<?= URL_ROOT ?>/member" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Quay lại
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Main Info -->
    <div class="col-xl-8">
        <!-- Profile Card -->
        <div class="card card-custom">
            <div class="card-body">
                <div class="d-flex align-items-center gap-4 mb-4 pb-4" style="border-bottom:1px solid var(--border-color)">
                    <div class="member-avatar-lg">
                        <?php if (!empty($member->avatar)): ?>
                            <img src="<?= URL_ROOT ?>/uploads/<?= $member->avatar ?>" alt="">
                        <?php else: ?>
                            <i class="bi bi-person-fill"></i>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h3 class="mb-1"><?= htmlspecialchars($member->full_name) ?></h3>
                        <p class="text-muted mb-1"><?= htmlspecialchars($member->email) ?></p>
                        <span class="status-badge status-<?= $member->status ?>"><?= ucfirst($member->status) ?></span>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="detail-item">
                            <label>Giới tính</label>
                            <span><?= $member->gender === 'male' ? 'Nam' : ($member->gender === 'female' ? 'Nữ' : 'Khác') ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-item">
                            <label>Ngày sinh</label>
                            <span><?= $member->date_of_birth ? date('d/m/Y', strtotime($member->date_of_birth)) : '—' ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-item">
                            <label>SĐT</label>
                            <span><?= htmlspecialchars($member->phone ?? '—') ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-item">
                            <label>Chiều cao</label>
                            <span><?= $member->height ? $member->height . ' cm' : '—' ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-item">
                            <label>Cân nặng</label>
                            <span><?= $member->weight ? $member->weight . ' kg' : '—' ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-item">
                            <label>BMI</label>
                            <span>
                                <?php if ($member->bmi): ?>
                                    <span class="badge <?= $member->bmi < 18.5 ? 'bg-warning' : ($member->bmi >= 25 ? 'bg-danger' : 'bg-success') ?>">
                                        <?= number_format($member->bmi, 1) ?>
                                    </span>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="detail-item">
                            <label>Địa chỉ</label>
                            <span><?= htmlspecialchars($member->address ?? '—') ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Liên hệ khẩn cấp</label>
                            <span><?= htmlspecialchars($member->emergency_contact ?? '—') ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>SĐT khẩn cấp</label>
                            <span><?= htmlspecialchars($member->emergency_phone ?? '—') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Body Metrics -->
        <div class="card card-custom mt-4">
            <div class="card-header-custom">
                <h5><i class="bi bi-speedometer2 me-2"></i>Lịch sử chỉ số cơ thể</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th>Ngày</th>
                                <th>Cân nặng</th>
                                <th>Body Fat</th>
                                <th>Muscle</th>
                                <th>BMI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($bodyMetrics)): ?>
                                <?php foreach ($bodyMetrics as $bm): ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($bm->measured_date)) ?></td>
                                    <td><?= $bm->weight ? $bm->weight . ' kg' : '—' ?></td>
                                    <td><?= $bm->body_fat ? $bm->body_fat . '%' : '—' ?></td>
                                    <td><?= $bm->muscle_mass ? $bm->muscle_mass . ' kg' : '—' ?></td>
                                    <td><?= $bm->bmi ? number_format($bm->bmi, 1) : '—' ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center text-muted py-4">Chưa có dữ liệu</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-xl-4">
        <!-- Active Package -->
        <div class="card card-custom">
            <div class="card-header-custom">
                <h5><i class="bi bi-box-seam me-2"></i>Gói tập</h5>
            </div>
            <div class="card-body">
                <?php if ($activePackage): ?>
                    <h5 class="text-primary mb-2"><?= htmlspecialchars($activePackage->package_name) ?></h5>
                    <p style="font-size:0.85rem" class="mb-1">
                        <strong>Bắt đầu:</strong> <?= date('d/m/Y', strtotime($activePackage->start_date)) ?>
                    </p>
                    <p style="font-size:0.85rem" class="mb-2">
                        <strong>Kết thúc:</strong> <?= date('d/m/Y', strtotime($activePackage->end_date)) ?>
                    </p>
                    <?php
                        $daysLeft = (strtotime($activePackage->end_date) - time()) / 86400;
                        $daysLeft = max(0, ceil($daysLeft));
                    ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="status-badge status-<?= $activePackage->status ?>"><?= ucfirst($activePackage->status) ?></span>
                        <span style="font-size:0.85rem;color:<?= $daysLeft <= 7 ? 'var(--warning)' : 'var(--success)' ?>">
                            <i class="bi bi-clock"></i> Còn <?= $daysLeft ?> ngày
                        </span>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted py-3">
                        <i class="bi bi-box display-6 d-block mb-2"></i>
                        Chưa có gói tập
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card card-custom mt-4">
            <div class="card-header-custom">
                <h5><i class="bi bi-bar-chart me-2"></i>Thống kê</h5>
            </div>
            <div class="card-body">
                <div class="detail-item mb-3">
                    <label>Ngày tham gia</label>
                    <span><?= date('d/m/Y', strtotime($member->join_date ?? $member->created_at)) ?></span>
                </div>
                <div class="detail-item">
                    <label>Ghi chú</label>
                    <span><?= htmlspecialchars($member->notes ?? 'Không có') ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.member-avatar-lg { width:100px;height:100px;border-radius:50%;background:var(--primary-light);display:flex;align-items:center;justify-content:center;overflow:hidden; }
.member-avatar-lg img { width:100%;height:100%;object-fit:cover; }
.member-avatar-lg i { font-size:2.5rem;color:var(--primary); }
.detail-item { display:flex;flex-direction:column;gap:4px; }
.detail-item label { font-size:0.75rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px; }
.detail-item span { font-size:0.9rem; }
</style>
