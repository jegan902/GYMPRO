<!-- Create Workout Plan -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Tạo giáo án mới</h4>
    <a href="<?= URL_ROOT ?>/workout" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
</div>

<form action="<?= URL_ROOT ?>/workout/store" method="POST" id="workoutForm">
    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">

    <div class="row g-4">
        <div class="col-xl-4">
            <div class="card card-custom">
                <div class="card-header-custom"><h5><i class="bi bi-info-circle me-2"></i>Thông tin cơ bản</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Tên giáo án <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="VD: Full Body Beginner">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mục tiêu</label>
                        <select name="goal" class="form-select">
                            <option value="general">Tổng thể</option>
                            <option value="strength">Sức mạnh</option>
                            <option value="muscle">Tăng cơ</option>
                            <option value="fat_loss">Giảm mỡ</option>
                            <option value="endurance">Chịu đựng</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Độ khó</label>
                        <select name="level" class="form-select">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate" selected>Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số ngày/tuần</label>
                        <input type="number" name="days_per_week" class="form-control" value="3" min="1" max="7">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Mô tả giáo án..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h5><i class="bi bi-list-task me-2"></i>Buổi tập & Bài tập</h5>
                    <button type="button" class="btn btn-sm btn-primary" onclick="addSession()"><i class="bi bi-plus-lg me-1"></i>Thêm buổi tập</button>
                </div>
                <div class="card-body" id="sessionsContainer">
                    <!-- Session 1 -->
                    <div class="session-block mb-4 p-3" style="border:1px solid var(--border-color);border-radius:var(--radius)" data-session="0">
                        <div class="row g-2 mb-3">
                            <div class="col-md-2">
                                <label class="form-label" style="font-size:0.7rem">Ngày</label>
                                <input type="number" name="sessions[0][day_number]" class="form-control form-control-sm" value="1" min="1" max="7">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label" style="font-size:0.7rem">Tên buổi tập</label>
                                <input type="text" name="sessions[0][session_name]" class="form-control form-control-sm" placeholder="VD: Ngực + Tay sau" value="Session 1">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-size:0.7rem">Focus</label>
                                <input type="text" name="sessions[0][focus_area]" class="form-control form-control-sm" placeholder="VD: Chest, Triceps">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.session-block').remove()"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                        <div class="exercises-list">
                            <div class="exercise-row mb-2 p-2" style="background:rgba(108,99,255,0.03);border-radius:6px">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-5">
                                        <select name="sessions[0][exercises][0][exercise_id]" class="form-select form-select-sm">
                                            <option value="">-- Chọn bài tập --</option>
                                            <?php foreach ($exercises as $ex): ?>
                                            <option value="<?= $ex->id ?>"><?= htmlspecialchars($ex->name) ?> (<?= $ex->muscle_group_vi ?? $ex->muscle_group_name ?>)</option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2"><input type="number" name="sessions[0][exercises][0][sets]" class="form-control form-control-sm" value="3" placeholder="Sets"></div>
                                    <div class="col-md-2"><input type="text" name="sessions[0][exercises][0][reps]" class="form-control form-control-sm" value="10-12" placeholder="Reps"></div>
                                    <div class="col-md-2"><input type="number" name="sessions[0][exercises][0][rest]" class="form-control form-control-sm" value="60" placeholder="Rest(s)"></div>
                                    <div class="col-md-1"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.exercise-row').remove()"><i class="bi bi-x"></i></button></div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addExerciseToSession(this.closest('.session-block'))"><i class="bi bi-plus me-1"></i>Thêm bài tập</button>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-check-lg me-2"></i>Lưu giáo án</button>
            </div>
        </div>
    </div>
</form>

<script>
let sessionIndex = 1;
const exerciseOptions = `<?php foreach ($exercises as $ex): ?><option value="<?= $ex->id ?>"><?= htmlspecialchars($ex->name) ?> (<?= $ex->muscle_group_vi ?? $ex->muscle_group_name ?>)</option><?php endforeach; ?>`;

function addSession() {
    const container = document.getElementById('sessionsContainer');
    const html = `
    <div class="session-block mb-4 p-3" style="border:1px solid var(--border-color);border-radius:var(--radius)" data-session="${sessionIndex}">
        <div class="row g-2 mb-3">
            <div class="col-md-2"><label class="form-label" style="font-size:0.7rem">Ngày</label><input type="number" name="sessions[${sessionIndex}][day_number]" class="form-control form-control-sm" value="${sessionIndex+1}" min="1" max="7"></div>
            <div class="col-md-5"><label class="form-label" style="font-size:0.7rem">Tên buổi tập</label><input type="text" name="sessions[${sessionIndex}][session_name]" class="form-control form-control-sm" value="Session ${sessionIndex+1}"></div>
            <div class="col-md-4"><label class="form-label" style="font-size:0.7rem">Focus</label><input type="text" name="sessions[${sessionIndex}][focus_area]" class="form-control form-control-sm"></div>
            <div class="col-md-1 d-flex align-items-end"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.session-block').remove()"><i class="bi bi-trash"></i></button></div>
        </div>
        <div class="exercises-list"></div>
        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addExerciseToSession(this.closest('.session-block'))"><i class="bi bi-plus me-1"></i>Thêm bài tập</button>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
    addExerciseToSession(container.lastElementChild);
    sessionIndex++;
}

function addExerciseToSession(sessionBlock) {
    const sIdx = sessionBlock.dataset.session;
    const list = sessionBlock.querySelector('.exercises-list');
    const eIdx = list.children.length;
    const html = `
    <div class="exercise-row mb-2 p-2" style="background:rgba(108,99,255,0.03);border-radius:6px">
        <div class="row g-2 align-items-end">
            <div class="col-md-5"><select name="sessions[${sIdx}][exercises][${eIdx}][exercise_id]" class="form-select form-select-sm"><option value="">-- Chọn --</option>${exerciseOptions}</select></div>
            <div class="col-md-2"><input type="number" name="sessions[${sIdx}][exercises][${eIdx}][sets]" class="form-control form-control-sm" value="3"></div>
            <div class="col-md-2"><input type="text" name="sessions[${sIdx}][exercises][${eIdx}][reps]" class="form-control form-control-sm" value="10-12"></div>
            <div class="col-md-2"><input type="number" name="sessions[${sIdx}][exercises][${eIdx}][rest]" class="form-control form-control-sm" value="60"></div>
            <div class="col-md-1"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.exercise-row').remove()"><i class="bi bi-x"></i></button></div>
        </div>
    </div>`;
    list.insertAdjacentHTML('beforeend', html);
}
</script>
