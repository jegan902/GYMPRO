<?php
/**
 * ProfileController
 * Quản lý thông tin cá nhân của người dùng/hội viên
 */
class ProfileController extends Controller
{
    private $userModel;
    private $memberModel;

    public function __construct()
    {
        Middleware::requireAuth(); // Bắt buộc đăng nhập
        $this->userModel = $this->model('UserModel');
        $this->memberModel = $this->model('MemberModel');
    }

    public function index()
    {
        $userId = Session::get('user_id');
        
        // Lấy thông tin user
        $user = $this->userModel->findById($userId);
        
        // Lấy thông tin member (chi tiết sức khỏe)
        $member = $this->memberModel->findByUserId($userId);

        $this->view('profile/index', [
            'title'     => 'Hồ sơ cá nhân',
            'user'      => $user,
            'member'    => $member,
            'no_layout' => true
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('profile');
        }

        $this->validateCSRF();
        
        $userId = Session::get('user_id');
        $member = $this->memberModel->findByUserId($userId);

        $userData = [
            'full_name' => $this->sanitize($_POST['full_name']),
            'phone'     => $this->sanitize($_POST['phone'])
        ];

        $memberData = [
            'gender'            => $_POST['gender'],
            'date_of_birth'     => $_POST['date_of_birth'],
            'height'            => $_POST['height'],
            'weight'            => $_POST['weight'],
            'address'           => $this->sanitize($_POST['address']),
            'emergency_contact' => $this->sanitize($_POST['emergency_contact']),
            'emergency_phone'   => $this->sanitize($_POST['emergency_phone'])
        ];

        // Tính toán BMI nếu có đủ thông tin
        if ($memberData['height'] > 0 && $memberData['weight'] > 0) {
            $heightMeters = $memberData['height'] / 100;
            $memberData['bmi'] = $memberData['weight'] / ($heightMeters * $heightMeters);
        }

        // Cập nhật bảng users
        $successUser = $this->userModel->update($userId, $userData);
        
        // Cập nhật bảng members
        $successMember = $this->memberModel->update($member->id, $memberData);

        if ($successUser && $successMember) {
            // Cập nhật tên trong session nếu thay đổi
            Session::set('user_name', $userData['full_name']);
            Session::flash('success', 'Cập nhật hồ sơ thành công!', 'success');
        } else {
            Session::flash('error', 'Có lỗi xảy ra khi cập nhật hồ sơ.', 'danger');
        }

        $this->redirect('profile');
    }
}
