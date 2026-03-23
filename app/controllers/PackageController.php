<?php
/**
 * PackageController
 */
class PackageController extends Controller
{
    private $packageModel;

    public function __construct()
    {
        Middleware::requireAuth();
        $this->packageModel = $this->model('PackageModel');
    }

    public function index()
    {
        if (Session::userRole() === 'member') {
            // Member: xem danh sách gói tập để đăng ký
            $packages = $this->packageModel->getActive();

            // Lấy member_id từ user_id
            $db = Database::getInstance();
            $db->query("SELECT id FROM members WHERE user_id = :uid");
            $db->bind(':uid', Session::userId());
            $member = $db->single();

            // Lấy gói tập đang active hoặc pending của member
            $activePackage = null;
            if ($member) {
                $db->query("SELECT mp.*, p.name as package_name FROM member_packages mp JOIN packages p ON mp.package_id = p.id WHERE mp.member_id = :mid AND mp.status IN ('active', 'pending') ORDER BY mp.created_at DESC LIMIT 1");
                $db->bind(':mid', $member->id);
                $activePackage = $db->single();
            }

            $this->view('packages/member_index', [
                'title'         => 'Gói tập',
                'packages'      => $packages,
                'activePackage' => $activePackage,
                'member'        => $member,
            ]);
        } else {
            Middleware::requireRole(['admin', 'staff']);
            $packages = $this->packageModel->findAll('price ASC');

            $this->view('packages/index', [
                'title'    => 'Quản lý Gói tập',
                'packages' => $packages,
            ]);
        }
    }

    /**
     * GET /package/show/{id} - Trang chi tiết gói tập (member checkout)
     */
    public function show($id = null)
    {
        if (!$id) $this->redirect('package');

        $pkg = $this->packageModel->findById($id);
        if (!$pkg || !$pkg->is_active) {
            Session::flash('error', 'Gói tập không tồn tại hoặc đã ngừng.', 'danger');
            $this->redirect('package');
        }

        if (Session::userRole() === 'member') {
            $db = Database::getInstance();
            $db->query("SELECT m.*, u.full_name, u.email, u.phone FROM members m JOIN users u ON m.user_id = u.id WHERE m.user_id = :uid");
            $db->bind(':uid', Session::userId());
            $member = $db->single();

            // Kiểm tra gói active/pending
            $activePackage = null;
            if ($member) {
                $db->query("SELECT mp.*, p.name as package_name FROM member_packages mp JOIN packages p ON mp.package_id = p.id WHERE mp.member_id = :mid AND mp.status IN ('active', 'pending') ORDER BY mp.created_at DESC LIMIT 1");
                $db->bind(':mid', $member->id);
                $activePackage = $db->single();
            }

            $this->view('packages/member_show', [
                'title'         => 'Đăng ký ' . $pkg->name,
                'package'       => $pkg,
                'member'        => $member,
                'activePackage' => $activePackage,
                'startDate'     => date('Y-m-d'),
                'endDate'       => date('Y-m-d', strtotime('+' . $pkg->duration . ' days')),
            ]);
        } else {
            $this->redirect('package');
        }
    }

    public function create()
    {
        Middleware::requireRole('admin');
        $this->view('packages/create', ['title' => 'Thêm Gói tập']);
    }

    public function store()
    {
        Middleware::requireRole('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('package');
        $this->validateCSRF();

        $data = [
            'name'        => $this->sanitize($_POST['name'] ?? ''),
            'duration'    => intval($_POST['duration'] ?? 30),
            'price'       => floatval($_POST['price'] ?? 0),
            'description' => $this->sanitize($_POST['description'] ?? ''),
            'features'    => $this->sanitize($_POST['features'] ?? ''),
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
        ];

        if (empty($data['name']) || $data['price'] <= 0) {
            Session::flash('error', 'Tên và giá gói tập không được để trống.', 'danger');
            $this->redirect('package/create');
        }

        $this->packageModel->create($data);
        Session::flash('success', 'Thêm gói tập thành công!', 'success');
        $this->redirect('package');
    }

    public function edit($id = null)
    {
        Middleware::requireRole('admin');
        if (!$id) $this->redirect('package');

        $pkg = $this->packageModel->findById($id);
        if (!$pkg) {
            Session::flash('error', 'Không tìm thấy gói tập.', 'danger');
            $this->redirect('package');
        }

        $this->view('packages/edit', ['title' => 'Sửa Gói tập', 'package' => $pkg]);
    }

    public function update($id = null)
    {
        Middleware::requireRole('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) $this->redirect('package');
        $this->validateCSRF();

        $data = [
            'name'        => $this->sanitize($_POST['name'] ?? ''),
            'duration'    => intval($_POST['duration'] ?? 30),
            'price'       => floatval($_POST['price'] ?? 0),
            'description' => $this->sanitize($_POST['description'] ?? ''),
            'features'    => $this->sanitize($_POST['features'] ?? ''),
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
        ];

        $this->packageModel->update($id, $data);
        Session::flash('success', 'Cập nhật gói tập thành công!', 'success');
        $this->redirect('package');
    }

    public function delete($id = null)
    {
        Middleware::requireRole('admin');
        if (!$id) $this->redirect('package');
        $this->packageModel->delete($id);
        Session::flash('success', 'Đã xóa gói tập.', 'success');
        $this->redirect('package');
    }

    /**
     * POST /package/assign - Assign package to member (Admin/Staff)
     */
    public function assign()
    {
        Middleware::requireRole(['admin', 'staff']);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('package');
        $this->validateCSRF();

        $memberId  = intval($_POST['member_id'] ?? 0);
        $packageId = intval($_POST['package_id'] ?? 0);
        $startDate = $_POST['start_date'] ?? date('Y-m-d');

        if (!$memberId || !$packageId) {
            Session::flash('error', 'Vui lòng chọn thành viên và gói tập.', 'danger');
            $this->redirect('package');
        }

        $pkg = $this->packageModel->findById($packageId);

        // Create invoice
        $invoiceModel = $this->model('InvoiceModel');
        $invoiceModel->create([
            'member_id'      => $memberId,
            'package_id'     => $packageId,
            'amount'         => $pkg->price,
            'payment_method' => $this->sanitize($_POST['payment_method'] ?? 'cash'),
            'payment_date'   => date('Y-m-d H:i:s'),
            'status'         => 'paid',
        ]);

        // Assign package
        $this->packageModel->assignToMember($memberId, $packageId, $startDate);

        // Nâng cấp role người dùng thành 'member' nếu trước đó chỉ là 'user'
        $db = Database::getInstance();
        $db->query("UPDATE users SET role = 'member' WHERE id = (SELECT user_id FROM members WHERE id = :mid)");
        $db->bind(':mid', $memberId);
        $db->execute();

        Session::flash('success', 'Gán gói tập và tạo hóa đơn thành công! Khách hàng đã được cấp quyền Hội viên.', 'success');
        $this->redirect('member/show/' . $memberId);
    }

    /**
     * POST /package/register - Member tự đăng ký gói tập
     */
    public function register()
    {
        Middleware::requireRole('member');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('package');
        $this->validateCSRF();

        $packageId = intval($_POST['package_id'] ?? 0);
        if (!$packageId) {
            Session::flash('error', 'Vui lòng chọn gói tập.', 'danger');
            $this->redirect('package');
        }

        $pkg = $this->packageModel->findById($packageId);
        if (!$pkg || !$pkg->is_active) {
            Session::flash('error', 'Gói tập không hợp lệ.', 'danger');
            $this->redirect('package');
        }

        // Lấy member_id
        $db = Database::getInstance();
        $db->query("SELECT id FROM members WHERE user_id = :uid");
        $db->bind(':uid', Session::userId());
        $member = $db->single();

        if (!$member) {
            Session::flash('error', 'Không tìm thấy thông tin hội viên.', 'danger');
            $this->redirect('package');
        }

        // Kiểm tra đã có gói active hoặc pending chưa
        $db->query("SELECT id FROM member_packages WHERE member_id = :mid AND status IN ('active', 'pending')");
        $db->bind(':mid', $member->id);
        if ($db->single()) {
            Session::flash('error', 'Bạn đang có gói tập đang hoạt động. Vui lòng đợi hết hạn hoặc liên hệ nhân viên.', 'danger');
            $this->redirect('package');
        }

        // Tạo hóa đơn 
        $invoiceModel = $this->model('InvoiceModel');
        $invoiceModel->create([
            'member_id'      => $member->id,
            'package_id'     => $packageId,
            'amount'         => $pkg->price,
            'payment_method' => 'transfer',
            'payment_date'   => date('Y-m-d H:i:s'),
            'status'         => 'paid',
        ]);

        // Gán gói tập (active — kích hoạt ngay)
        $this->packageModel->assignToMember($member->id, $packageId);

        Session::flash('success', 'Đăng ký gói tập thành công!', 'success');
        $this->redirect('package');
    }
}
