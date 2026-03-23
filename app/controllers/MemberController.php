<?php
/**
 * MemberController
 * CRUD operations for members
 */
class MemberController extends Controller
{
    private $memberModel;

    public function __construct()
    {
        Middleware::requireRole(['admin', 'staff']);
        $this->memberModel = $this->model('MemberModel');
    }

    /**
     * GET /member - List all members
     */
    public function index()
    {
        $search = $this->sanitize($_GET['search'] ?? '');
        $status = $this->sanitize($_GET['status'] ?? '');

        $members = $this->memberModel->getAllWithUser($search, $status);

        $this->view('members/index', [
            'title'   => 'Quản lý Thành viên',
            'members' => $members,
            'search'  => $search,
            'status'  => $status,
        ]);
    }

    /**
     * GET /member/create - Show create form
     */
    public function create()
    {
        $this->view('members/create', [
            'title' => 'Thêm Thành viên mới',
        ]);
    }

    /**
     * POST /member/store - Store new member
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('member');
        }

        $this->validateCSRF();

        $userData = [
            'full_name' => $this->sanitize($_POST['full_name'] ?? ''),
            'email'     => $this->sanitize($_POST['email'] ?? ''),
            'phone'     => $this->sanitize($_POST['phone'] ?? ''),
            'password'  => $_POST['password'] ?? '123456',
        ];

        $memberData = [
            'date_of_birth'    => $_POST['date_of_birth'] ?? null,
            'gender'           => $_POST['gender'] ?? 'male',
            'height'           => !empty($_POST['height']) ? floatval($_POST['height']) : null,
            'weight'           => !empty($_POST['weight']) ? floatval($_POST['weight']) : null,
            'address'          => $this->sanitize($_POST['address'] ?? ''),
            'emergency_contact'=> $this->sanitize($_POST['emergency_contact'] ?? ''),
            'emergency_phone'  => $this->sanitize($_POST['emergency_phone'] ?? ''),
            'status'           => 'active',
            'notes'            => $this->sanitize($_POST['notes'] ?? ''),
        ];

        // Validate
        $errors = [];
        if (empty($userData['full_name'])) $errors[] = 'Họ tên không được để trống.';
        if (empty($userData['email'])) $errors[] = 'Email không được để trống.';
        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email không hợp lệ.';

        $userModel = $this->model('UserModel');
        if ($userModel->emailExists($userData['email'])) $errors[] = 'Email đã được sử dụng.';

        if (!empty($errors)) {
            Session::flash('error', implode('<br>', $errors), 'danger');
            $this->redirect('member/create');
        }

        // Handle avatar upload
        if (!empty($_FILES['avatar']['name'])) {
            $avatarName = $this->uploadAvatar($_FILES['avatar']);
            if ($avatarName) {
                $userModel->update($userModel->findByEmail($userData['email'])->id ?? 0, ['avatar' => $avatarName]);
            }
        }

        $result = $this->memberModel->createWithUser($userData, $memberData);

        if ($result) {
            Session::flash('success', 'Thêm thành viên thành công!', 'success');
        } else {
            Session::flash('error', 'Có lỗi xảy ra. Vui lòng thử lại.', 'danger');
        }
        $this->redirect('member');
    }

    /**
     * GET /member/edit/{id}
     */
    public function edit($id = null)
    {
        if (!$id) $this->redirect('member');

        $member = $this->memberModel->getWithUser($id);
        if (!$member) {
            Session::flash('error', 'Không tìm thấy thành viên.', 'danger');
            $this->redirect('member');
        }

        $activePackage = $this->memberModel->getActivePackage($id);

        $this->view('members/edit', [
            'title'         => 'Sửa Thành viên',
            'member'        => $member,
            'activePackage' => $activePackage,
        ]);
    }

    /**
     * POST /member/update/{id}
     */
    public function update($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) {
            $this->redirect('member');
        }

        $this->validateCSRF();

        $userData = [
            'full_name' => $this->sanitize($_POST['full_name'] ?? ''),
            'email'     => $this->sanitize($_POST['email'] ?? ''),
            'phone'     => $this->sanitize($_POST['phone'] ?? ''),
        ];

        $memberData = [
            'date_of_birth'    => $_POST['date_of_birth'] ?? null,
            'gender'           => $_POST['gender'] ?? 'male',
            'height'           => !empty($_POST['height']) ? floatval($_POST['height']) : null,
            'weight'           => !empty($_POST['weight']) ? floatval($_POST['weight']) : null,
            'address'          => $this->sanitize($_POST['address'] ?? ''),
            'emergency_contact'=> $this->sanitize($_POST['emergency_contact'] ?? ''),
            'emergency_phone'  => $this->sanitize($_POST['emergency_phone'] ?? ''),
            'status'           => $_POST['status'] ?? 'active',
            'notes'            => $this->sanitize($_POST['notes'] ?? ''),
        ];

        // Handle avatar upload
        if (!empty($_FILES['avatar']['name'])) {
            $avatarName = $this->uploadAvatar($_FILES['avatar']);
            if ($avatarName) {
                $userData['avatar'] = $avatarName;
            }
        }

        $result = $this->memberModel->updateWithUser($id, $userData, $memberData);

        if ($result) {
            Session::flash('success', 'Cập nhật thành viên thành công!', 'success');
        } else {
            Session::flash('error', 'Có lỗi xảy ra. Vui lòng thử lại.', 'danger');
        }
        $this->redirect('member/edit/' . $id);
    }

    /**
     * GET /member/delete/{id}
     */
    public function delete($id = null)
    {
        Middleware::requireRole('admin');

        if (!$id) $this->redirect('member');

        $member = $this->memberModel->findById($id);
        if ($member) {
            // Delete user account too
            $userModel = $this->model('UserModel');
            $userModel->delete($member->user_id);
            Session::flash('success', 'Đã xóa thành viên.', 'success');
        } else {
            Session::flash('error', 'Không tìm thấy thành viên.', 'danger');
        }
        $this->redirect('member');
    }

    /**
     * POST /member/grant/{id} - Cấp quyền truy cập Hệ thống trợ lý (từ user -> member)
     */
    public function grant($id = null)
    {
        Middleware::requireRole(['admin', 'staff']);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) {
            $this->redirect('member');
        }
        $this->validateCSRF();

        $member = $this->memberModel->findById($id);
        if ($member) {
            $db = Database::getInstance();
            $db->query("UPDATE users SET role = 'member' WHERE id = :uid");
            $db->bind(':uid', $member->user_id);
            $db->execute();
            Session::flash('success', 'Đã cấp quyền Hội viên thành công!', 'success');
        } else {
            Session::flash('error', 'Không tìm thấy thành viên.', 'danger');
        }
        $this->redirect('member/show/' . $id);
    }

    /**
     * GET /member/view/{id}
     */
    public function show($id = null)
    {
        if (!$id) $this->redirect('member');

        $member = $this->memberModel->getWithUser($id);
        if (!$member) {
            Session::flash('error', 'Không tìm thấy thành viên.', 'danger');
            $this->redirect('member');
        }

        $activePackage = $this->memberModel->getActivePackage($id);

        // Get body metrics history
        $db = Database::getInstance();
        $db->query("SELECT * FROM body_metrics WHERE member_id = :id ORDER BY measured_date DESC LIMIT 10");
        $db->bind(':id', $id);
        $bodyMetrics = $db->resultSet();

        // Get recent exercise logs
        $db->query("SELECT el.*, e.name as exercise_name FROM exercise_logs el
                    JOIN exercises e ON el.exercise_id = e.id
                    WHERE el.member_id = :id ORDER BY el.log_date DESC LIMIT 10");
        $db->bind(':id', $id);
        $exerciseLogs = $db->resultSet();

        $this->view('members/show', [
            'title'         => 'Chi tiết Thành viên',
            'member'        => $member,
            'activePackage' => $activePackage,
            'bodyMetrics'   => $bodyMetrics,
            'exerciseLogs'  => $exerciseLogs,
        ]);
    }

    /**
     * Upload avatar helper
     */
    private function uploadAvatar($file)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) return null;
        if ($file['size'] > MAX_FILE_SIZE) return null;
        if (!in_array($file['type'], ALLOWED_IMAGE_TYPES)) return null;

        $uploadDir = APP_ROOT . '/public/uploads/avatars/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'avatar_' . uniqid() . '.' . $ext;

        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            return 'avatars/' . $filename;
        }
        return null;
    }
}
