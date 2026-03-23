<?php
/**
 * AuthController
 * Handles login, register, logout
 */
class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('UserModel');
    }

    /**
     * GET /auth/login
     */
    public function login()
    {
        Middleware::guest();
        $this->view('auth/login', [
            'title'     => 'Đăng nhập',
            'no_layout' => true
        ]);
    }

    /**
     * POST /auth/authenticate
     */
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/login');
        }

        $this->validateCSRF();

        $email    = $this->sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validate
        $errors = [];
        if (empty($email)) $errors[] = 'Email không được để trống.';
        if (empty($password)) $errors[] = 'Mật khẩu không được để trống.';

        if (!empty($errors)) {
            Session::flash('error', implode('<br>', $errors), 'danger');
            $this->redirect('auth/login');
        }

        // Find user
        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            Session::flash('error', 'Email hoặc mật khẩu không đúng.', 'danger');
            $this->redirect('auth/login');
        }

        if (!$user->is_active) {
            Session::flash('error', 'Tài khoản đã bị khóa. Liên hệ admin.', 'danger');
            $this->redirect('auth/login');
        }

        // Set session
        Session::set('user_id', $user->id);
        Session::set('user_name', $user->full_name);
        Session::set('user_email', $user->email);
        Session::set('user_role', $user->role);
        Session::set('user_avatar', $user->avatar);

        // Update last login
        $this->userModel->updateLastLogin($user->id);

        Session::flash('success', 'Đăng nhập thành công! Chào mừng ' . $user->full_name, 'success');
        
        if ($user->role === 'user') {
            $this->redirect('');
        } else {
            $this->redirect('dashboard');
        }
    }

    /**
     * GET /auth/register
     */
    public function register()
    {
        Middleware::guest();
        $this->view('auth/register', [
            'title'     => 'Đăng ký tài khoản',
            'no_layout' => true
        ]);
    }

    /**
     * POST /auth/store
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/register');
        }

        $this->validateCSRF();

        $data = [
            'full_name' => $this->sanitize($_POST['full_name'] ?? ''),
            'email'     => $this->sanitize($_POST['email'] ?? ''),
            'phone'     => $this->sanitize($_POST['phone'] ?? ''),
            'password'  => $_POST['password'] ?? '',
        ];
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validate
        $errors = [];
        if (empty($data['full_name'])) $errors[] = 'Họ tên không được để trống.';
        if (empty($data['email'])) $errors[] = 'Email không được để trống.';
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email không hợp lệ.';
        if (strlen($data['password']) < 6) $errors[] = 'Mật khẩu phải ít nhất 6 ký tự.';
        if ($data['password'] !== $confirmPassword) $errors[] = 'Xác nhận mật khẩu không khớp.';
        if ($this->userModel->emailExists($data['email'])) $errors[] = 'Email đã được sử dụng.';

        if (!empty($errors)) {
            Session::flash('error', implode('<br>', $errors), 'danger');
            $this->redirect('auth/register');
        }

        // Create user
        $userId = $this->userModel->register($data);

        if ($userId) {
            // Tự động tạo hồ sơ hội viên mặc định (Role ban đầu là 'user')
            $memberModel = $this->model('MemberModel');
            $memberModel->create([
                'user_id'   => $userId,
                'join_date' => date('Y-m-d'),
                'status'    => 'active'
            ]);

            Session::flash('success', 'Đăng ký thành công! Vui lòng đăng nhập để tiếp tục.', 'success');
            $this->redirect('auth/login');
        } else {
            Session::flash('error', 'Có lỗi xảy ra. Vui lòng thử lại.', 'danger');
            $this->redirect('auth/register');
        }
    }

    /**
     * GET /auth/logout
     */
    public function logout()
    {
        Session::destroy();
        session_start();
        Session::flash('success', 'Đã đăng xuất thành công.', 'success');
        $this->redirect('auth/login');
    }
}
