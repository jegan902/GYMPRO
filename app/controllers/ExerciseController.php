<?php
/**
 * ExerciseController
 */
class ExerciseController extends Controller
{
    private $exerciseModel;

    public function __construct()
    {
        Middleware::requireAuth();
        $this->exerciseModel = $this->model('ExerciseModel');
    }

    public function index()
    {
        $search = $this->sanitize($_GET['search'] ?? '');
        $exercises = $this->exerciseModel->getAllWithMuscle($search);
        $muscleGroups = $this->exerciseModel->getMuscleGroups();

        $hasPT = true;
        if (Session::userRole() === 'member') {
            $memberModel = $this->model('MemberModel');
            $hasPT = $memberModel->hasPTPackage(Session::userId());
        }

        $this->view('exercises/index', [
            'title'        => 'Bài tập',
            'exercises'    => $exercises,
            'muscleGroups' => $muscleGroups,
            'search'       => $search,
            'hasPT'        => $hasPT,
        ]);
    }

    public function create()
    {
        Middleware::requireRole(['admin', 'staff']);
        $muscleGroups = $this->exerciseModel->getMuscleGroups();

        $this->view('exercises/create', [
            'title'        => 'Thêm bài tập',
            'muscleGroups' => $muscleGroups,
        ]);
    }

    public function store()
    {
        Middleware::requireRole(['admin', 'staff']);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('exercise');
        $this->validateCSRF();

        $data = [
            'name'            => $this->sanitize($_POST['name'] ?? ''),
            'muscle_group_id' => intval($_POST['muscle_group_id'] ?? 0),
            'description'     => $this->sanitize($_POST['description'] ?? ''),
            'level'           => $_POST['level'] ?? 'beginner',
            'sets_recommended'=> intval($_POST['sets_recommended'] ?? 3),
            'reps_recommended'=> $this->sanitize($_POST['reps_recommended'] ?? '10-12'),
            'equipment'       => $this->sanitize($_POST['equipment'] ?? ''),
            'video_url'       => $this->sanitize($_POST['video_url'] ?? ''),
        ];

        if (empty($data['name'])) {
            Session::flash('error', 'Tên bài tập không được để trống.', 'danger');
            $this->redirect('exercise/create');
        }

        $this->exerciseModel->create($data);
        Session::flash('success', 'Thêm bài tập thành công!', 'success');
        $this->redirect('exercise');
    }

    public function edit($id = null)
    {
        Middleware::requireRole(['admin', 'staff']);
        if (!$id) $this->redirect('exercise');

        $exercise = $this->exerciseModel->findById($id);
        if (!$exercise) {
            Session::flash('error', 'Không tìm thấy bài tập.', 'danger');
            $this->redirect('exercise');
        }

        $muscleGroups = $this->exerciseModel->getMuscleGroups();

        $this->view('exercises/edit', [
            'title'        => 'Sửa bài tập',
            'exercise'     => $exercise,
            'muscleGroups' => $muscleGroups,
        ]);
    }

    public function update($id = null)
    {
        Middleware::requireRole(['admin', 'staff']);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) $this->redirect('exercise');
        $this->validateCSRF();

        $data = [
            'name'            => $this->sanitize($_POST['name'] ?? ''),
            'muscle_group_id' => intval($_POST['muscle_group_id'] ?? 0),
            'description'     => $this->sanitize($_POST['description'] ?? ''),
            'level'           => $_POST['level'] ?? 'beginner',
            'sets_recommended'=> intval($_POST['sets_recommended'] ?? 3),
            'reps_recommended'=> $this->sanitize($_POST['reps_recommended'] ?? '10-12'),
            'equipment'       => $this->sanitize($_POST['equipment'] ?? ''),
            'video_url'       => $this->sanitize($_POST['video_url'] ?? ''),
        ];

        $this->exerciseModel->update($id, $data);
        Session::flash('success', 'Cập nhật bài tập thành công!', 'success');
        $this->redirect('exercise');
    }

    public function delete($id = null)
    {
        Middleware::requireRole('admin');
        if (!$id) $this->redirect('exercise');
        $this->exerciseModel->delete($id);
        Session::flash('success', 'Đã xóa bài tập.', 'success');
        $this->redirect('exercise');
    }
}
