<?php
/**
 * AttendanceController
 */
class AttendanceController extends Controller
{
    private $attendanceModel;

    public function __construct()
    {
        Middleware::requireAuth();
        $this->attendanceModel = $this->model('AttendanceModel');
    }

    public function index()
    {
        $todayList = $this->attendanceModel->getTodayAttendance();
        $totalToday = $this->attendanceModel->countToday();
        $currentlyIn = $this->attendanceModel->currentlyInGym();
        $weeklyStats = $this->attendanceModel->getWeeklyStats();

        // Get all active members for check-in dropdown
        $memberModel = $this->model('MemberModel');
        $members = $memberModel->getAllWithUser('', 'active');

        $this->view('attendance/index', [
            'title'       => 'Check-in',
            'todayList'   => $todayList,
            'totalToday'  => $totalToday,
            'currentlyIn' => $currentlyIn,
            'weeklyStats' => $weeklyStats,
            'members'     => $members,
        ]);
    }

    public function checkin()
    {
        Middleware::requireRole(['admin', 'staff']);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('attendance');
        $this->validateCSRF();

        $memberId = intval($_POST['member_id'] ?? 0);
        $method = $_POST['method'] ?? 'manual';

        if (!$memberId) {
            Session::flash('error', 'Vui lòng chọn hội viên.', 'danger');
            $this->redirect('attendance');
        }

        $result = $this->attendanceModel->checkIn($memberId, $method);
        if ($result) {
            Session::flash('success', 'Check-in thành công!', 'success');
        } else {
            Session::flash('error', 'Hội viên đã check-in hôm nay rồi.', 'warning');
        }
        $this->redirect('attendance');
    }

    public function checkout()
    {
        Middleware::requireRole(['admin', 'staff']);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('attendance');
        $this->validateCSRF();

        $memberId = intval($_POST['member_id'] ?? 0);
        $result = $this->attendanceModel->checkOut($memberId);

        if ($result) {
            Session::flash('success', 'Check-out thành công!', 'success');
        } else {
            Session::flash('error', 'Không tìm thấy check-in hoạt động.', 'warning');
        }
        $this->redirect('attendance');
    }

    public function history()
    {
        $memberId = !empty($_GET['member_id']) ? intval($_GET['member_id']) : null;
        $dateFrom = !empty($_GET['date_from']) ? $_GET['date_from'] : null;
        $dateTo = !empty($_GET['date_to']) ? $_GET['date_to'] : null;

        $records = $this->attendanceModel->getHistory($memberId, $dateFrom, $dateTo, 100);

        $memberModel = $this->model('MemberModel');
        $members = $memberModel->getAllWithUser();

        $this->view('attendance/history', [
            'title'    => 'Lịch sử check-in',
            'records'  => $records,
            'members'  => $members,
            'filters'  => ['member_id' => $memberId, 'date_from' => $dateFrom, 'date_to' => $dateTo],
        ]);
    }
}
