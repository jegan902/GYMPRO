<!-- Dashboard Content -->
<div class="dashboard-grid">
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-primary">
                <div class="stat-card-body">
                    <div class="stat-info">
                        <h6>Thành viên</h6>
                        <h2><?= number_format($stats->totalMembers) ?></h2>
                        <span class="stat-trend up"><i class="bi bi-arrow-up-short"></i> Tổng cộng</span>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="<?= URL_ROOT ?>/member"><i class="bi bi-arrow-right"></i> Xem chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-success">
                <div class="stat-card-body">
                    <div class="stat-info">
                        <h6>Gói tập Active</h6>
                        <h2><?= number_format($stats->activePackages) ?></h2>
                        <span class="stat-trend up"><i class="bi bi-check-circle"></i> Đang hoạt động</span>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="<?= URL_ROOT ?>/package"><i class="bi bi-arrow-right"></i> Xem chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-warning">
                <div class="stat-card-body">
                    <div class="stat-info">
                        <h6>Check-in hôm nay</h6>
                        <h2><?= number_format($stats->todayCheckins) ?></h2>
                        <span class="stat-trend"><i class="bi bi-clock"></i> Hôm nay</span>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-qr-code-scan"></i>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="<?= URL_ROOT ?>/checkin"><i class="bi bi-arrow-right"></i> Xem chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-info">
                <div class="stat-card-body">
                    <div class="stat-info">
                        <h6>Doanh thu tháng</h6>
                        <h2><?= number_format($stats->monthlyRevenue, 0, ',', '.') ?>₫</h2>
                        <span class="stat-trend"><i class="bi bi-calendar3"></i> Tháng này</span>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="<?= URL_ROOT ?>/invoice"><i class="bi bi-arrow-right"></i> Xem chi tiết</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Tables Row -->
    <div class="row g-4">
        <!-- Recent Members -->
        <div class="col-xl-8">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h5><i class="bi bi-people me-2"></i>Thành viên mới</h5>
                    <a href="<?= URL_ROOT ?>/member" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Thành viên</th>
                                    <th>Email</th>
                                    <th>Ngày tham gia</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recentMembers)): ?>
                                    <?php foreach ($recentMembers as $member): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="member-avatar-sm">
                                                    <?php if (!empty($member->avatar)): ?>
                                                        <img src="<?= URL_ROOT ?>/uploads/<?= $member->avatar ?>" alt="">
                                                    <?php else: ?>
                                                        <i class="bi bi-person-fill"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <span><?= htmlspecialchars($member->full_name) ?></span>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($member->email) ?></td>
                                        <td><?= date('d/m/Y', strtotime($member->join_date ?? $member->created_at)) ?></td>
                                        <td>
                                            <span class="status-badge status-<?= $member->status ?? 'active' ?>">
                                                <?= ucfirst($member->status ?? 'active') ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Chưa có thành viên nào</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expiring Packages -->
        <div class="col-xl-4">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h5><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Sắp hết hạn</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($expiringPackages)): ?>
                        <?php foreach ($expiringPackages as $pkg): ?>
                        <div class="expiring-item">
                            <div class="expiring-info">
                                <strong><?= htmlspecialchars($pkg->full_name) ?></strong>
                                <span class="text-muted"><?= htmlspecialchars($pkg->package_name) ?></span>
                            </div>
                            <div class="expiring-date">
                                <i class="bi bi-calendar-x"></i>
                                <?= date('d/m/Y', strtotime($pkg->end_date)) ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-check-circle display-6 d-block mb-2"></i>
                            Không có gói sắp hết hạn
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
