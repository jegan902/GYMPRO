<!-- Members List -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Danh sách thành viên</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Quản lý tất cả hội viên phòng gym</p>
    </div>
    <a href="<?= URL_ROOT ?>/member/create" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Thêm thành viên
    </a>
</div>

<!-- Filters -->
<div class="card card-custom mb-4">
    <div class="card-body py-3">
        <form method="GET" action="<?= URL_ROOT ?>/member" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Tên, email, SĐT..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="expired" <?= $status === 'expired' ? 'selected' : '' ?>>Expired</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1"></i> Lọc</button>
                <a href="<?= URL_ROOT ?>/member" class="btn btn-outline-secondary"><i class="bi bi-x-lg me-1"></i> Xóa lọc</a>
            </div>
        </form>
    </div>
</div>

<!-- Members Table -->
<div class="card card-custom">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Thành viên</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>BMI</th>
                        <th>Trạng thái</th>
                        <th>Ngày tham gia</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($members)): ?>
                        <?php foreach ($members as $i => $m): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="member-avatar-sm">
                                        <?php if (!empty($m->avatar)): ?>
                                            <img src="<?= URL_ROOT ?>/uploads/<?= $m->avatar ?>" alt="">
                                        <?php else: ?>
                                            <i class="bi bi-person-fill"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <strong><?= htmlspecialchars($m->full_name) ?></strong>
                                        <div style="font-size:0.75rem;color:var(--text-muted)">
                                            <?= $m->gender === 'male' ? 'Nam' : ($m->gender === 'female' ? 'Nữ' : 'Khác') ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($m->email) ?></td>
                            <td><?= htmlspecialchars($m->phone ?? '—') ?></td>
                            <td>
                                <?php if ($m->bmi): ?>
                                    <span class="badge <?= $m->bmi < 18.5 ? 'bg-warning' : ($m->bmi >= 25 ? 'bg-danger' : 'bg-success') ?>">
                                        <?= number_format($m->bmi, 1) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="status-badge status-<?= $m->status ?>">
                                    <?= ucfirst($m->status) ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($m->join_date ?? $m->created_at)) ?></td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="<?= URL_ROOT ?>/member/show/<?= $m->id ?>" class="btn btn-sm btn-outline-info" title="Xem">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= URL_ROOT ?>/member/edit/<?= $m->id ?>" class="btn btn-sm btn-outline-primary" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= URL_ROOT ?>/member/delete/<?= $m->id ?>" class="btn btn-sm btn-outline-danger" title="Xóa"
                                       data-confirm="Bạn có chắc muốn xóa thành viên này?">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="bi bi-people display-4 d-block mb-2"></i>
                                Chưa có thành viên nào
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
