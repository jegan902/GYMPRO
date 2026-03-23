<?php
/**
 * ReportController - Statistics & Reports
 */
class ReportController extends Controller
{
    public function __construct()
    {
        Middleware::requireAuth();
        Middleware::requireRole(['admin', 'staff']);
    }

    public function index()
    {
        $memberModel = $this->model('MemberModel');
        $invoiceModel = $this->model('InvoiceModel');
        $attendModel = $this->model('AttendanceModel');
        $packageModel = $this->model('PackageModel');

        // --- Auto-expire packages (Time-based logic) ---
        $packageModel->expirePackages();

        // --- Stats ---
        $totalMembers = $memberModel->countByStatus('active');
        $totalInactive = $memberModel->countByStatus('inactive') + $memberModel->countByStatus('expired');
        $totalRevenue = $invoiceModel->getTotalRevenue();
        $todayCheckins = $attendModel->countToday();

        // Revenue by month (current year)
        $revenueByMonth = $invoiceModel->getRevenueByMonth(date('Y'));

        // Members by month (new joins last 6 months)
        $db = Database::getInstance();
        $db->query("SELECT DATE_FORMAT(join_date, '%Y-%m') as month, COUNT(*) as total
                     FROM members WHERE join_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                     GROUP BY month ORDER BY month");
        $membersByMonth = $db->resultSet();

        // Check-ins last 7 days - format for chart
        $rawWeekly = $attendModel->getWeeklyStats();
        $weeklyCheckins = [];
        $dayNames = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'];
        foreach ($rawWeekly as $d) {
            $dayOfWeek = date('w', strtotime($d->date));
            $weeklyCheckins[] = (object)[
                'day_label' => $dayNames[$dayOfWeek] . ' ' . date('d/m', strtotime($d->date)),
                'total'     => $d->total,
            ];
        }

        // Expiring soon
        $db->query("SELECT mp.*, u.full_name, p.name as package_name
                     FROM member_packages mp
                     JOIN members m ON mp.member_id = m.id
                     JOIN users u ON m.user_id = u.id
                     JOIN packages p ON mp.package_id = p.id
                     WHERE mp.status = 'active' AND mp.end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
                     ORDER BY mp.end_date");
        $expiringSoon = $db->resultSet();

        $this->view('reports/index', [
            'title'          => 'Báo cáo & Thống kê',
            'totalMembers'   => $totalMembers,
            'totalInactive'  => $totalInactive,
            'totalRevenue'   => $totalRevenue,
            'todayCheckins'  => $todayCheckins,
            'revenueByMonth' => $revenueByMonth,
            'membersByMonth' => $membersByMonth,
            'weeklyCheckins' => $weeklyCheckins,
            'expiringSoon'   => $expiringSoon,
        ]);
    }
}
