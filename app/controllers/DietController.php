<?php
/**
 * DietController
 */
class DietController extends Controller
{
    private $dietModel;

    public function __construct()
    {
        Middleware::requireAuth();
        $this->dietModel = $this->model('DietModel');
    }

    public function index()
    {
        $plans = $this->dietModel->getAllWithMeals();

        $this->view('diets/index', [
            'title' => 'Dinh dưỡng',
            'plans' => $plans,
        ]);
    }

    public function create()
    {
        Middleware::requireRole(['admin', 'staff']);

        $this->view('diets/create', [
            'title' => 'Tạo kế hoạch dinh dưỡng',
        ]);
    }

    public function store()
    {
        Middleware::requireRole(['admin', 'staff']);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('diet');
        $this->validateCSRF();

        $data = [
            'name'           => $this->sanitize($_POST['name'] ?? ''),
            'goal'           => $_POST['goal'] ?? 'maintain',
            'total_calories' => intval($_POST['total_calories'] ?? 0),
            'protein_grams'  => intval($_POST['protein_grams'] ?? 0),
            'carbs_grams'    => intval($_POST['carbs_grams'] ?? 0),
            'fat_grams'      => intval($_POST['fat_grams'] ?? 0),
            'description'    => $this->sanitize($_POST['description'] ?? ''),
        ];

        if (empty($data['name'])) {
            Session::flash('error', 'Tên kế hoạch không được để trống.', 'danger');
            $this->redirect('diet/create');
        }

        $planId = $this->dietModel->create($data);

        // Add meals
        if (isset($_POST['meals']) && is_array($_POST['meals'])) {
            foreach ($_POST['meals'] as $index => $meal) {
                if (empty($meal['meal_name'])) continue;
                $this->dietModel->addMeal([
                    'diet_plan_id' => $planId,
                    'meal_name'    => $this->sanitize($meal['meal_name']),
                    'food_items'   => $this->sanitize($meal['food_items'] ?? ''),
                    'calories'     => intval($meal['calories'] ?? 0),
                    'protein'      => floatval($meal['protein'] ?? 0),
                    'carbs'        => floatval($meal['carbs'] ?? 0),
                    'fat'          => floatval($meal['fat'] ?? 0),
                    'sort_order'   => $index,
                ]);
            }
        }

        Session::flash('success', 'Tạo kế hoạch dinh dưỡng thành công!', 'success');
        $this->redirect('diet');
    }

    public function show($id = null)
    {
        if (!$id) $this->redirect('diet');
        $plan = $this->dietModel->getWithMeals($id);
        if (!$plan) {
            Session::flash('error', 'Không tìm thấy kế hoạch.', 'danger');
            $this->redirect('diet');
        }

        $this->view('diets/show', [
            'title' => $plan->name,
            'plan'  => $plan,
        ]);
    }

    public function delete($id = null)
    {
        Middleware::requireRole('admin');
        if (!$id) $this->redirect('diet');
        $this->dietModel->delete($id);
        Session::flash('success', 'Đã xóa kế hoạch dinh dưỡng.', 'success');
        $this->redirect('diet');
    }
}
