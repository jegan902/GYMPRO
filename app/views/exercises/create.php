<!-- Create Exercise -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Thêm bài tập mới</h4>
    <a href="<?= URL_ROOT ?>/exercise" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
</div>

<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card card-custom">
            <div class="card-header-custom"><h5><i class="bi bi-activity me-2"></i>Thông tin bài tập</h5></div>
            <div class="card-body">
                <form action="<?= URL_ROOT ?>/exercise/store" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Tên bài tập <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="VD: Bench Press">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nhóm cơ</label>
                            <select name="muscle_group_id" class="form-select">
                                <option value="0">-- Chọn nhóm cơ --</option>
                                <?php foreach ($muscleGroups as $mg): ?>
                                    <option value="<?= $mg->id ?>"><?= htmlspecialchars($mg->name_vi ?? $mg->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Độ khó</label>
                            <select name="level" class="form-select">
                                <option value="beginner">Beginner</option>
                                <option value="intermediate" selected>Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sets khuyến nghị</label>
                            <input type="number" name="sets_recommended" class="form-control" value="3" min="1" max="10">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Reps khuyến nghị</label>
                            <input type="text" name="reps_recommended" class="form-control" value="10-12" placeholder="VD: 10-12">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dụng cụ</label>
                            <input type="text" name="equipment" class="form-control" placeholder="VD: Barbell, Dumbbell">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Link video (YouTube)</label>
                            <input type="url" name="video_url" class="form-control" placeholder="https://youtube.com/...">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Mô tả / Hướng dẫn</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Cách thực hiện bài tập..."></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-2"></i>Lưu bài tập</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
