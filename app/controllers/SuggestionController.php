<?php
/**
 * SuggestionController - AI Rule-based Suggestions
 */
class SuggestionController extends Controller
{
    public function __construct()
    {
        Middleware::requireAuth();
        require_once APP_ROOT . '/core/SuggestionEngine.php';
    }

    public function index()
    {
        $memberModel = $this->model('MemberModel');
        $logModel = $this->model('ExerciseLogModel');
        $metricModel = $this->model('BodyMetricModel');

        // Get member data
        if (Session::userRole() === 'member') {
            $member = $memberModel->getByUserId(Session::userId());
        } else {
            $memberId = intval($_GET['member_id'] ?? 0);
            $member = $memberId ? $memberModel->getWithUser($memberId) : null;
        }

        $suggestions = [];
        $workoutRec = null;
        $latest = null;

        if ($member) {
            // Get latest body metrics
            $latest = $metricModel->getLatest($member->id);

            // Count workouts this week
            $logs = $logModel->getByMember($member->id, 50);
            $thisWeek = 0;
            $weekAgo = date('Y-m-d', strtotime('-7 days'));
            $uniqueDates = [];
            foreach ($logs as $log) {
                if ($log->log_date >= $weekAgo) {
                    $uniqueDates[$log->log_date] = true;
                }
            }
            $thisWeek = count($uniqueDates);

            $bmi = floatval($latest->bmi ?? $member->bmi ?? 0);
            $goal = $_GET['goal'] ?? 'maintain';

            $suggestions = SuggestionEngine::generate([
                'bmi' => $bmi,
                'goal' => $goal,
                'workouts_per_week' => $thisWeek,
                'body_fat' => $latest->body_fat ?? 0,
            ]);

            $workoutRec = SuggestionEngine::getWorkoutRecommendation($bmi, $goal);
        }

        $members = $memberModel->getAllWithUser('', 'active');

        $this->view('suggestions/index', [
            'title'       => 'Gợi ý AI',
            'suggestions' => $suggestions,
            'workoutRec'  => $workoutRec,
            'member'      => $member,
            'latest'      => $latest,
            'members'     => $members,
        ]);
    }
}
