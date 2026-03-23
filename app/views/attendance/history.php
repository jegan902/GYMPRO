<!-- Attendance History -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Lịch sử Check-in</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem">Tra cứu lịch sử điểm danh</p>
    </div>
    <a href="<?= URL_ROOT ?>/attendance" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
</div>

<!-- Filters -->
<div class="card card-custom mb-4">
    <div class="card-body py-3">
        <form method="GET" action="<?= URL_ROOT ?>/attendance/history" class="d-flex gap-3 flex-wrap align-items-end">
            <div>
                <label class="form-label" style="font-size:0.7rem">Hội viên</label>
                <select name="member_id" class="form-select form-select-sm" style="min-width:200px">
                    <option value="">Tất cả</option>
                    <?php foreach ($members as $m): ?>
                        <option value="<?= $m->id ?>" <?= ($filters['member_id'] ?? '') == $m->id ? 'selected' : '' ?>><?= htmlspecialchars($m->full_name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="form-label" style="font-size:0.7rem">Từ ngày</label>
                <input type="date" name="date_from" class="form-control form-control-sm" value="<?= $filters['date_from'] ?? '' ?>">
            </div>
            <div>
                <label class="form-label" style="font-size:0.7rem">Đến ngày</label>
                <input type="date" name="date_to" class="form-control form-control-sm" value="<?= $filters['date_to'] ?? '' ?>">
            </div>
            <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search me-1"></i>Lọc</button>
            <a href="<?= URL_ROOT ?>/attendance/history" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
        </form>
    </div>
</div>

<!-- History Table -->
<div class="card card-custom">
    <?php if (!empty($records)): ?>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead><tr><th>Ngày</th><th>Hội viên</th><th>Check-in</th><th>Check-out</th><th>Thời gian tập</th><th>Phương thức</th></tr></thead>
            <tbody>
            <?php foreach ($records as $r): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($r->check_in_time)) ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm"><?= strtoupper(substr($r->full_name, 0, 1)) ?></div>
                            <?= htmlspecialchars($r->full_name) ?>
                        </div>
                    </td>
                    <td><?= date('H:i', strtotime($r->check_in_time)) ?></td>
                    <td><?= $r->check_out_time ? date('H:i', strtotime($r->check_out_time)) : '<span class="text-muted">--</span>' ?></td>
                    <td>
                        <?php if ($r->check_out_time): ?>
                            <?php
                                $diff = strtotime($r->check_out_time) - strtotime($r->check_in_time);
                                $h = floor($diff / 3600); $m = floor(($diff % 3600) / 60);
                            ?>
                            <?= $h ?>h <?= $m ?>m
                        <?php else: ?>
                            <span class="badge bg-success" style="font-size:0.65rem">Đang tập</span>
                        <?php endif; ?>
                    </td>
                    <td><span class="badge bg-<?= $r->method === 'qr' ? 'info' : 'secondary' ?>" style="font-size:0.65rem"><?= strtoupper($r->method) ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="card-body text-center text-muted py-4">Không có kết quả</div>
    <?php endif; ?>
</div>

<style>
.avatar-sm { width:32px; height:32px; border-radius:50%; background:var(--primary); color:#fff; display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:700; }
</style>
