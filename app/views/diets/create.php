<!-- Create Diet Plan -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Tạo kế hoạch dinh dưỡng</h4>
    <a href="<?= URL_ROOT ?>/diet" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
</div>

<form action="<?= URL_ROOT ?>/diet/store" method="POST">
    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
    <div class="row g-4">
        <div class="col-xl-4">
            <div class="card card-custom">
                <div class="card-header-custom"><h5><i class="bi bi-info-circle me-2"></i>Thông tin cơ bản</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Tên kế hoạch <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="VD: Giảm mỡ – 1800kcal">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mục tiêu</label>
                        <select name="goal" class="form-select">
                            <option value="lose_fat">Giảm mỡ</option>
                            <option value="build_muscle">Tăng cơ</option>
                            <option value="gain_weight">Tăng cân</option>
                            <option value="maintain" selected>Duy trì</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tổng Calories/ngày</label>
                        <input type="number" name="total_calories" class="form-control" placeholder="VD: 2000" id="totalCal">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="form-label" style="font-size:0.7rem">Protein (g)</label>
                            <input type="number" name="protein_grams" class="form-control form-control-sm" placeholder="150" id="totalP">
                        </div>
                        <div class="col-4">
                            <label class="form-label" style="font-size:0.7rem">Carbs (g)</label>
                            <input type="number" name="carbs_grams" class="form-control form-control-sm" placeholder="200" id="totalC">
                        </div>
                        <div class="col-4">
                            <label class="form-label" style="font-size:0.7rem">Fat (g)</label>
                            <input type="number" name="fat_grams" class="form-control form-control-sm" placeholder="60" id="totalF">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Mô tả kế hoạch..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h5><i class="bi bi-list-ul me-2"></i>Bữa ăn trong ngày</h5>
                    <button type="button" class="btn btn-sm btn-primary" onclick="addMealRow()"><i class="bi bi-plus-lg me-1"></i>Thêm bữa</button>
                </div>
                <div class="card-body" id="mealsContainer">
                    <!-- Meal 1: Sáng -->
                    <div class="meal-row mb-3 p-3" style="border:1px solid var(--border-color);border-radius:var(--radius)">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label class="form-label" style="font-size:0.7rem">Bữa</label>
                                <select name="meals[0][meal_name]" class="form-select form-select-sm">
                                    <option value="Bữa sáng" selected>Bữa sáng</option>
                                    <option value="Bữa phụ sáng">Bữa phụ sáng</option>
                                    <option value="Bữa trưa">Bữa trưa</option>
                                    <option value="Bữa phụ chiều">Bữa phụ chiều</option>
                                    <option value="Bữa tối">Bữa tối</option>
                                    <option value="Bữa phụ tối">Bữa phụ tối</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label" style="font-size:0.7rem">Thực phẩm</label>
                                <textarea name="meals[0][food_items]" class="form-control form-control-sm" rows="2" placeholder="VD: 2 trứng luộc, 1 bát yến mạch, 1 quả chuối"></textarea>
                            </div>
                            <div class="col-md-1"><label class="form-label" style="font-size:0.7rem">Kcal</label><input type="number" name="meals[0][calories]" class="form-control form-control-sm" placeholder="400"></div>
                            <div class="col-md-1"><label class="form-label" style="font-size:0.7rem">P(g)</label><input type="number" name="meals[0][protein]" class="form-control form-control-sm" placeholder="30"></div>
                            <div class="col-md-1"><label class="form-label" style="font-size:0.7rem">C(g)</label><input type="number" name="meals[0][carbs]" class="form-control form-control-sm" placeholder="50"></div>
                            <div class="col-md-1 d-flex align-items-end"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.meal-row').remove()"><i class="bi bi-x"></i></button></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-check-lg me-2"></i>Lưu kế hoạch</button>
            </div>
        </div>
    </div>
</form>

<script>
let mealIndex = 1;
const mealOptions = '<option value="Bữa sáng">Bữa sáng</option><option value="Bữa phụ sáng">Bữa phụ sáng</option><option value="Bữa trưa">Bữa trưa</option><option value="Bữa phụ chiều">Bữa phụ chiều</option><option value="Bữa tối">Bữa tối</option><option value="Bữa phụ tối">Bữa phụ tối</option>';
function addMealRow() {
    const c = document.getElementById('mealsContainer');
    c.insertAdjacentHTML('beforeend', `
    <div class="meal-row mb-3 p-3" style="border:1px solid var(--border-color);border-radius:var(--radius)">
        <div class="row g-2">
            <div class="col-md-3"><label class="form-label" style="font-size:0.7rem">Bữa</label><select name="meals[${mealIndex}][meal_name]" class="form-select form-select-sm">${mealOptions}</select></div>
            <div class="col-md-5"><label class="form-label" style="font-size:0.7rem">Thực phẩm</label><textarea name="meals[${mealIndex}][food_items]" class="form-control form-control-sm" rows="2" placeholder="Danh sách thực phẩm..."></textarea></div>
            <div class="col-md-1"><label class="form-label" style="font-size:0.7rem">Kcal</label><input type="number" name="meals[${mealIndex}][calories]" class="form-control form-control-sm"></div>
            <div class="col-md-1"><label class="form-label" style="font-size:0.7rem">P(g)</label><input type="number" name="meals[${mealIndex}][protein]" class="form-control form-control-sm"></div>
            <div class="col-md-1"><label class="form-label" style="font-size:0.7rem">C(g)</label><input type="number" name="meals[${mealIndex}][carbs]" class="form-control form-control-sm"></div>
            <div class="col-md-1 d-flex align-items-end"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.meal-row').remove()"><i class="bi bi-x"></i></button></div>
        </div>
    </div>`);
    mealIndex++;
}
</script>
