<?php
/**
 * NotificationController
 */
class NotificationController extends Controller
{
    private $notifModel;

    public function __construct()
    {
        Middleware::requireAuth();
        $this->notifModel = $this->model('NotificationModel');
    }

    public function index()
    {
        $notifications = $this->notifModel->getByUser(Session::userId(), 50);
        $unread = $this->notifModel->getUnreadCount(Session::userId());

        $this->view('notifications/index', [
            'title'         => 'Thông báo',
            'notifications' => $notifications,
            'unread'        => $unread,
        ]);
    }

    public function read($id = null)
    {
        if ($id) $this->notifModel->markRead($id);
        $this->redirect('notification');
    }

    public function readAll()
    {
        $this->notifModel->markAllRead(Session::userId());
        Session::flash('success', 'Đã đọc tất cả thông báo.', 'success');
        $this->redirect('notification');
    }

    public function create()
    {
        Middleware::requireRole('admin');
        $this->view('notifications/create', ['title' => 'Gửi thông báo']);
    }

    public function send()
    {
        Middleware::requireRole('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('notification');
        $this->validateCSRF();

        $title = $this->sanitize($_POST['title'] ?? '');
        $message = $this->sanitize($_POST['message'] ?? '');
        $type = $_POST['type'] ?? 'system';
        $target = $_POST['target'] ?? 'all';

        if (empty($title) || empty($message)) {
            Session::flash('error', 'Tiêu đề và nội dung không trống.', 'danger');
            $this->redirect('notification/create');
        }

        if ($target === 'all') {
            $this->notifModel->createForAllMembers($title, $message, $type);
        } else {
            $userId = intval($target);
            $this->notifModel->create(['user_id' => $userId, 'title' => $title, 'message' => $message, 'type' => $type]);
        }

        Session::flash('success', 'Gửi thông báo thành công!', 'success');
        $this->redirect('notification');
    }
}
