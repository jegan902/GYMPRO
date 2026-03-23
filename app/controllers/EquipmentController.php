<?php
/**
 * EquipmentController
 */
class EquipmentController extends Controller
{
    private $equipModel;

    public function __construct()
    {
        Middleware::requireAuth();
        Middleware::requireRole(['admin', 'staff']);
        $this->equipModel = $this->model('EquipmentModel');
    }

    public function index()
    {
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        $equipments = $this->equipModel->getAllFiltered($search, $status);
        $totalActive = $this->equipModel->countByStatus('active');
        $totalBroken = $this->equipModel->countByStatus('broken');
        $totalMaint = $this->equipModel->countByStatus('maintenance');
        $needMaint = $this->equipModel->getNeedingMaintenance();

        $this->view('equipment/index', [
            'title'       => 'Thiết bị',
            'equipments'  => $equipments,
            'totalActive' => $totalActive,
            'totalBroken' => $totalBroken,
            'totalMaint'  => $totalMaint,
            'needMaint'   => $needMaint,
            'search'      => $search,
            'status'      => $status,
        ]);
    }

    public function create()
    {
        Middleware::requireRole('admin');
        $this->view('equipment/create', ['title' => 'Thêm thiết bị']);
    }

    public function store()
    {
        Middleware::requireRole('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('equipment');
        $this->validateCSRF();

        $data = [
            'name'                  => $this->sanitize($_POST['name'] ?? ''),
            'category'              => $this->sanitize($_POST['category'] ?? ''),
            'status'                => $_POST['status'] ?? 'active',
            'purchase_date'         => !empty($_POST['purchase_date']) ? $_POST['purchase_date'] : null,
            'last_maintenance_date' => !empty($_POST['last_maintenance_date']) ? $_POST['last_maintenance_date'] : null,
            'next_maintenance_date' => !empty($_POST['next_maintenance_date']) ? $_POST['next_maintenance_date'] : null,
            'quantity'              => intval($_POST['quantity'] ?? 1),
            'note'                  => $this->sanitize($_POST['note'] ?? ''),
        ];

        if (empty($data['name'])) {
            Session::flash('error', 'Tên thiết bị không được trống.', 'danger');
            $this->redirect('equipment/create');
        }

        $this->equipModel->create($data);
        Session::flash('success', 'Thêm thiết bị thành công!', 'success');
        $this->redirect('equipment');
    }

    public function edit($id = null)
    {
        Middleware::requireRole('admin');
        if (!$id) $this->redirect('equipment');
        $equip = $this->equipModel->findById($id);
        if (!$equip) { Session::flash('error', 'Không tìm thấy.', 'danger'); $this->redirect('equipment'); }

        $this->view('equipment/edit', ['title' => 'Sửa thiết bị', 'equipment' => $equip]);
    }

    public function update($id = null)
    {
        Middleware::requireRole('admin');
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('equipment');
        $this->validateCSRF();

        $data = [
            'name'                  => $this->sanitize($_POST['name'] ?? ''),
            'category'              => $this->sanitize($_POST['category'] ?? ''),
            'status'                => $_POST['status'] ?? 'active',
            'purchase_date'         => !empty($_POST['purchase_date']) ? $_POST['purchase_date'] : null,
            'last_maintenance_date' => !empty($_POST['last_maintenance_date']) ? $_POST['last_maintenance_date'] : null,
            'next_maintenance_date' => !empty($_POST['next_maintenance_date']) ? $_POST['next_maintenance_date'] : null,
            'quantity'              => intval($_POST['quantity'] ?? 1),
            'note'                  => $this->sanitize($_POST['note'] ?? ''),
        ];

        $this->equipModel->update($id, $data);
        Session::flash('success', 'Cập nhật thành công!', 'success');
        $this->redirect('equipment');
    }

    public function delete($id = null)
    {
        Middleware::requireRole('admin');
        if (!$id) $this->redirect('equipment');
        $this->equipModel->delete($id);
        Session::flash('success', 'Đã xóa thiết bị.', 'success');
        $this->redirect('equipment');
    }
}
