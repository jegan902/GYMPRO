<?php
/**
 * WorkoutController
 */
class WorkoutController extends Controller
{
    private $workoutModel;

    public function __construct()
    {
        Middleware::requireAuth();
        $this->workoutModel = $this->model('WorkoutModel');
    }

    public function index()
    {
        $plans = $this->workoutModel->getAllPlans();

        $hasPT = true;
        if (Session::userRole() === 'member') {
            $memberModel = $this->model('MemberModel');
            $hasPT = $memberModel->hasPTPackage(Session::userId());
        }

        $this->view('workouts/index', [
            'title' => 'Giáo án tập',
            'plans' => $plans,
            'hasPT' => $hasPT,
        ]);
    }

    public function create()
    {
        Middleware::requireRole(['admin', 'staff']);
        $exerciseModel = $this->model('ExerciseModel');
        $exercises = $exerciseModel->getAllWithMuscle();
        $muscleGroups = $exerciseModel->getMuscleGroups();

        $this->view('workouts/create', [
            'title'        => 'Tạo giáo án',
            'exercises'    => $exercises,
            'muscleGroups' => $muscleGroups,
        ]);
    }

    public function store()
    {
        Middleware::requireRole(['admin', 'staff']);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('workout');
        $this->validateCSRF();

        $data = [
            'name'          => $this->sanitize($_POST['name'] ?? ''),
            'description'   => $this->sanitize($_POST['description'] ?? ''),
            'level'         => $_POST['level'] ?? 'beginner',
            'goal'          => $this->sanitize($_POST['goal'] ?? 'general'),
            'days_per_week' => intval($_POST['days_per_week'] ?? 3),
        ];

        if (empty($data['name'])) {
            Session::flash('error', 'Tên giáo án không được để trống.', 'danger');
            $this->redirect('workout/create');
        }

        $planId = $this->workoutModel->create($data);

        // Create sessions and add exercises
        if (isset($_POST['sessions']) && is_array($_POST['sessions'])) {
            foreach ($_POST['sessions'] as $sIndex => $sessionData) {
                $sessionId = $this->workoutModel->createSession([
                    'workout_plan_id' => $planId,
                    'day_number'      => intval($sessionData['day_number'] ?? ($sIndex + 1)),
                    'session_name'    => $this->sanitize($sessionData['session_name'] ?? 'Session ' . ($sIndex + 1)),
                    'focus_area'      => $this->sanitize($sessionData['focus_area'] ?? ''),
                ]);

                if (isset($sessionData['exercises']) && is_array($sessionData['exercises'])) {
                    foreach ($sessionData['exercises'] as $eIndex => $exData) {
                        if (empty($exData['exercise_id'])) continue;
                        $this->workoutModel->addExerciseToSession([
                            'workout_session_id' => $sessionId,
                            'exercise_id'        => intval($exData['exercise_id']),
                            'sets'               => intval($exData['sets'] ?? 3),
                            'reps'               => $this->sanitize($exData['reps'] ?? '10-12'),
                            'rest_seconds'       => intval($exData['rest'] ?? 60),
                            'sort_order'         => $eIndex,
                        ]);
                    }
                }
            }
        }

        Session::flash('success', 'Tạo giáo án thành công!', 'success');
        $this->redirect('workout');
    }

    public function show($id = null)
    {
        if (!$id) $this->redirect('workout');
        $plan = $this->workoutModel->getWithSessions($id);
        if (!$plan) {
            Session::flash('error', 'Không tìm thấy giáo án.', 'danger');
            $this->redirect('workout');
        }

        $hasPT = true;
        if (Session::userRole() === 'member') {
            $memberModel = $this->model('MemberModel');
            $hasPT = $memberModel->hasPTPackage(Session::userId());
        }

        $this->view('workouts/show', [
            'title' => $plan->name,
            'plan'  => $plan,
            'hasPT' => $hasPT,
        ]);
    }

    public function delete($id = null)
    {
        Middleware::requireRole('admin');
        if (!$id) $this->redirect('workout');
        $this->workoutModel->delete($id);
        Session::flash('success', 'Đã xóa giáo án.', 'success');
        $this->redirect('workout');
    }
}
