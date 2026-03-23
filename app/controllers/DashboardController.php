<?php
/**
 * DashboardController
 * Main dashboard after login
 */
class DashboardController extends Controller
{
    public function __construct()
    {
        Middleware::requireAuth();
    }

    public function index()
    {
        $role = Session::userRole();
        
        if ($role === 'user') {
            Session::flash('error', 'Hệ thống trợ lý ảo chỉ dành cho Hội viên. Vui lòng mua gói dịch vụ để được cấp quyền truy cập!', 'warning');
            header('Location: ' . URL_ROOT . '/service');
            exit;
        } elseif ($role === 'member') {
            $this->memberDashboard();
        } else {
            $this->adminDashboard();
        }
    }

    /**
     * Dashboard cho Admin / Staff
     */
    private function adminDashboard()
    {
        $db = Database::getInstance();

        // Stats for dashboard
        $stats = new stdClass();

        // Total members
        $db->query("SELECT COUNT(*) as total FROM members");
        $stats->totalMembers = $db->single()->total;

        // Active packages
        $db->query("SELECT COUNT(*) as total FROM member_packages WHERE status = 'active'");
        $stats->activePackages = $db->single()->total;

        // Today check-ins
        $db->query("SELECT COUNT(*) as total FROM attendance WHERE DATE(check_in_time) = CURDATE()");
        $stats->todayCheckins = $db->single()->total;

        // Monthly revenue
        $db->query("SELECT COALESCE(SUM(amount), 0) as total FROM invoices WHERE status = 'paid' AND MONTH(payment_date) = MONTH(CURDATE()) AND YEAR(payment_date) = YEAR(CURDATE())");
        $stats->monthlyRevenue = $db->single()->total;

        // Recent members
        $db->query("SELECT m.*, u.full_name, u.email, u.avatar FROM members m JOIN users u ON m.user_id = u.id ORDER BY m.created_at DESC LIMIT 5");
        $recentMembers = $db->resultSet();

        // Expiring packages (next 7 days)
        $db->query("SELECT mp.*, m.id as mid, u.full_name, p.name as package_name
                     FROM member_packages mp
                     JOIN members m ON mp.member_id = m.id
                     JOIN users u ON m.user_id = u.id
                     JOIN packages p ON mp.package_id = p.id
                     WHERE mp.status = 'active' AND mp.end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
                     ORDER BY mp.end_date ASC LIMIT 5");
        $expiringPackages = $db->resultSet();

        $this->view('dashboard/index', [
            'title'            => 'Dashboard',
            'stats'            => $stats,
            'recentMembers'    => $recentMembers,
            'expiringPackages' => $expiringPackages,
        ]);
    }

    /**
     * Dashboard cho Hội viên (Member)
     */
    private function memberDashboard()
    {
        $db = Database::getInstance();
        $userId = Session::userId();

        // Lấy thông tin member
        $db->query("SELECT m.* FROM members m WHERE m.user_id = :uid");
        $db->bind(':uid', $userId);
        $member = $db->single();

        // Gói tập hiện tại
        $activePackage = null;
        if ($member) {
            $db->query("SELECT mp.*, p.name as package_name, p.duration, p.price
                         FROM member_packages mp
                         JOIN packages p ON mp.package_id = p.id
                         WHERE mp.member_id = :mid AND mp.status = 'active'
                         ORDER BY mp.end_date DESC LIMIT 1");
            $db->bind(':mid', $member->id);
            $activePackage = $db->single();
        }

        // Chỉ số BMI
        $latestMetric = null;
        if ($member) {
            $db->query("SELECT * FROM body_metrics WHERE member_id = :mid ORDER BY measured_date DESC LIMIT 1");
            $db->bind(':mid', $member->id);
            $latestMetric = $db->single();
        }

        // Tính BMI
        $bmi = null;
        $bmiCategory = '';
        if ($member && $member->height > 0 && $member->weight > 0) {
            $heightM = $member->height / 100;
            $bmi = round($member->weight / ($heightM * $heightM), 1);
            if ($bmi < 18.5) $bmiCategory = 'Thiếu cân';
            elseif ($bmi < 25) $bmiCategory = 'Bình thường';
            elseif ($bmi < 30) $bmiCategory = 'Thừa cân';
            else $bmiCategory = 'Béo phì';
        }

        // Lịch sử tập gần đây (5 buổi)
        $recentWorkouts = [];
        if ($member) {
            $db->query("SELECT el.*, e.name as exercise_name, mg.name_vi as muscle_group_name
                         FROM exercise_logs el
                         JOIN exercises e ON el.exercise_id = e.id
                         LEFT JOIN muscle_groups mg ON e.muscle_group_id = mg.id
                         WHERE el.member_id = :mid
                         ORDER BY el.log_date DESC LIMIT 5");
            $db->bind(':mid', $member->id);
            $recentWorkouts = $db->resultSet();
        }

        // Số buổi check-in tháng này
        $monthlyCheckins = 0;
        if ($member) {
            $db->query("SELECT COUNT(*) as total FROM attendance WHERE member_id = :mid AND MONTH(check_in_time) = MONTH(CURDATE()) AND YEAR(check_in_time) = YEAR(CURDATE())");
            $db->bind(':mid', $member->id);
            $result = $db->single();
            $monthlyCheckins = $result ? $result->total : 0;
        }

        $this->view('dashboard/member', [
            'title'           => 'Dashboard',
            'member'          => $member,
            'activePackage'   => $activePackage,
            'latestMetric'    => $latestMetric,
            'bmi'             => $bmi,
            'bmiCategory'     => $bmiCategory,
            'recentWorkouts'  => $recentWorkouts,
            'monthlyCheckins' => $monthlyCheckins,
        ]);
    }
}
