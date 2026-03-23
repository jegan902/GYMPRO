<?php
/**
 * TrackingController - Body Metrics & Exercise Logs
 */
class TrackingController extends Controller
{
    public function __construct()
    {
        Middleware::requireAuth();
    }

    /**
     * Body Metrics dashboard
     */
    public function index()
    {
        $metricModel = $this->model('BodyMetricModel');
        $memberModel = $this->model('MemberModel');

        // If member role, show own metrics; otherwise show all recent
        if (Session::userRole() === 'member') {
            $member = $memberModel->getByUserId(Session::userId());
            $metrics = $member ? $metricModel->getByMember($member->id) : [];
            $latest = $member ? $metricModel->getLatest($member->id) : null;
            $weightData = $member ? $metricModel->getChartData($member->id, 'weight') : [];
            $bmiData = $member ? $metricModel->getChartData($member->id, 'bmi') : [];
        } else {
            $metrics = $metricModel->getAllRecent(30);
            $latest = null;
            $weightData = [];
            $bmiData = [];
            $member = null;
        }

        $members = $memberModel->getAllWithUser('', 'active');

        $this->view('tracking/metrics', [
            'title'      => 'Theo dõi cơ thể',
            'metrics'    => $metrics,
            'latest'     => $latest,
            'weightData' => $weightData,
            'bmiData'    => $bmiData,
            'members'    => $members,
            'member'     => $member,
        ]);
    }

    /**
     * Add body metric
     */
    public function addMetric()
    {
        Middleware::requireRole(['admin', 'staff', 'member']);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('tracking');
        $this->validateCSRF();

        $metricModel = $this->model('BodyMetricModel');

        // Determine member id
        if (Session::userRole() === 'member') {
            $memberModel = $this->model('MemberModel');
            $member = $memberModel->getByUserId(Session::userId());
            $memberId = $member ? $member->id : 0;
        } else {
            $memberId = intval($_POST['member_id'] ?? 0);
        }

        if (!$memberId) {
            Session::flash('error', 'Không tìm thấy hội viên.', 'danger');
            $this->redirect('tracking');
        }

        $weight = floatval($_POST['weight'] ?? 0);
        $height = null;
        // Get member height for BMI
        $memberModel = $this->model('MemberModel');
        $memberInfo = $memberModel->findById($memberId);
        if ($memberInfo && $memberInfo->height > 0 && $weight > 0) {
            $h = $memberInfo->height / 100;
            $bmi = round($weight / ($h * $h), 2);
        } else {
            $bmi = null;
        }

        $data = [
            'member_id'     => $memberId,
            'weight'        => $weight > 0 ? $weight : null,
            'body_fat'      => !empty($_POST['body_fat']) ? floatval($_POST['body_fat']) : null,
            'muscle_mass'   => !empty($_POST['muscle_mass']) ? floatval($_POST['muscle_mass']) : null,
            'bmi'           => $bmi,
            'waist'         => !empty($_POST['waist']) ? floatval($_POST['waist']) : null,
            'chest'         => !empty($_POST['chest']) ? floatval($_POST['chest']) : null,
            'arm'           => !empty($_POST['arm']) ? floatval($_POST['arm']) : null,
            'thigh'         => !empty($_POST['thigh']) ? floatval($_POST['thigh']) : null,
            'notes'         => $this->sanitize($_POST['notes'] ?? ''),
            'measured_date' => $_POST['measured_date'] ?? date('Y-m-d'),
        ];

        $metricModel->create($data);
        Session::flash('success', 'Đã lưu chỉ số cơ thể!', 'success');
        $this->redirect('tracking');
    }

    /**
     * Exercise Logs
     */
    public function logs()
    {
        $logModel = $this->model('ExerciseLogModel');
        $memberModel = $this->model('MemberModel');
        $exerciseModel = $this->model('ExerciseModel');

        if (Session::userRole() === 'member') {
            $member = $memberModel->getByUserId(Session::userId());
            $groupedLogs = $member ? $logModel->getGroupedByDate($member->id) : [];
        } else {
            $memberId = intval($_GET['member_id'] ?? 0);
            if ($memberId) {
                $member = $memberModel->findById($memberId);
                $groupedLogs = $logModel->getGroupedByDate($memberId);
            } else {
                $member = null;
                $groupedLogs = [];
            }
        }

        $members = $memberModel->getAllWithUser('', 'active');
        $exercises = $exerciseModel->getAllWithMuscle();

        $this->view('tracking/logs', [
            'title'       => 'Nhật ký tập luyện',
            'groupedLogs' => $groupedLogs,
            'members'     => $members,
            'exercises'   => $exercises,
            'member'      => $member ?? null,
        ]);
    }

    /**
     * Add exercise log
     */
    public function addLog()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('tracking/logs');
        $this->validateCSRF();

        $logModel = $this->model('ExerciseLogModel');

        if (Session::userRole() === 'member') {
            $memberModel = $this->model('MemberModel');
            $member = $memberModel->getByUserId(Session::userId());
            $memberId = $member ? $member->id : 0;
        } else {
            $memberId = intval($_POST['member_id'] ?? 0);
        }

        $exerciseId = intval($_POST['exercise_id'] ?? 0);
        if (!$memberId || !$exerciseId) {
            Session::flash('error', 'Vui lòng chọn hội viên và bài tập.', 'danger');
            $this->redirect('tracking/logs');
        }

        $sets = intval($_POST['total_sets'] ?? 1);
        for ($i = 1; $i <= $sets; $i++) {
            $reps = intval($_POST["reps_{$i}"] ?? $_POST['reps'] ?? 10);
            $weight = floatval($_POST["weight_{$i}"] ?? $_POST['weight_used'] ?? 0);

            $logModel->create([
                'member_id'   => $memberId,
                'exercise_id' => $exerciseId,
                'set_number'  => $i,
                'reps'        => $reps,
                'weight'      => $weight,
                'log_date'    => $_POST['log_date'] ?? date('Y-m-d'),
                'notes'       => $this->sanitize($_POST['notes'] ?? ''),
            ]);
        }

        Session::flash('success', "Đã ghi {$sets} set!", 'success');
        $this->redirect('tracking/logs');
    }
}
