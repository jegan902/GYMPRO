<?php
/**
 * InvoiceController
 */
class InvoiceController extends Controller
{
    private $invoiceModel;

    public function __construct()
    {
        Middleware::requireRole(['admin', 'staff']);
        $this->invoiceModel = $this->model('InvoiceModel');
    }

    public function index()
    {
        $search = $this->sanitize($_GET['search'] ?? '');
        $status = $this->sanitize($_GET['status'] ?? '');

        $invoices = $this->invoiceModel->getAllWithDetails($search, $status);
        $totalRevenue = $this->invoiceModel->getTotalRevenue(date('m'), date('Y'));

        $this->view('invoices/index', [
            'title'        => 'Quản lý Hóa đơn',
            'invoices'     => $invoices,
            'totalRevenue' => $totalRevenue,
            'search'       => $search,
            'status'       => $status,
        ]);
    }

    public function create()
    {
        $memberModel  = $this->model('MemberModel');
        $packageModel = $this->model('PackageModel');

        $members  = $memberModel->getAllWithUser();
        $packages = $packageModel->getActive();

        $this->view('invoices/create', [
            'title'    => 'Tạo Hóa đơn',
            'members'  => $members,
            'packages' => $packages,
        ]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('invoice');
        $this->validateCSRF();

        $data = [
            'member_id'      => intval($_POST['member_id'] ?? 0),
            'package_id'     => !empty($_POST['package_id']) ? intval($_POST['package_id']) : null,
            'amount'         => floatval($_POST['amount'] ?? 0),
            'payment_method' => $this->sanitize($_POST['payment_method'] ?? 'cash'),
            'payment_date'   => $_POST['payment_date'] ?? date('Y-m-d H:i:s'),
            'status'         => $_POST['status'] ?? 'pending',
            'transaction_id' => $this->sanitize($_POST['transaction_id'] ?? ''),
            'notes'          => $this->sanitize($_POST['notes'] ?? ''),
        ];

        if (!$data['member_id'] || $data['amount'] <= 0) {
            Session::flash('error', 'Vui lòng chọn thành viên và nhập số tiền.', 'danger');
            $this->redirect('invoice/create');
        }

        $this->invoiceModel->create($data);

        // If paid and has package, assign package
        if ($data['status'] === 'paid' && $data['package_id']) {
            $packageModel = $this->model('PackageModel');
            $packageModel->assignToMember($data['member_id'], $data['package_id']);
        }

        Session::flash('success', 'Tạo hóa đơn thành công!', 'success');
        $this->redirect('invoice');
    }

    public function show($id = null)
    {
        if (!$id) $this->redirect('invoice');
        $invoice = $this->invoiceModel->getWithDetails($id);
        if (!$invoice) {
            Session::flash('error', 'Không tìm thấy hóa đơn.', 'danger');
            $this->redirect('invoice');
        }

        $this->view('invoices/show', [
            'title'   => 'Chi tiết Hóa đơn #' . $id,
            'invoice' => $invoice,
        ]);
    }

    public function updateStatus($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) $this->redirect('invoice');
        $this->validateCSRF();

        $status = $this->sanitize($_POST['status'] ?? '');
        $this->invoiceModel->update($id, [
            'status'       => $status,
            'payment_date' => $status === 'paid' ? date('Y-m-d H:i:s') : null,
        ]);

        // If marking as paid and invoice has package
        if ($status === 'paid') {
            $invoice = $this->invoiceModel->findById($id);
            if ($invoice && $invoice->package_id) {
                $packageModel = $this->model('PackageModel');
                $packageModel->assignToMember($invoice->member_id, $invoice->package_id);
            }
        }

        Session::flash('success', 'Cập nhật trạng thái hóa đơn thành công!', 'success');
        $this->redirect('invoice');
    }

    public function delete($id = null)
    {
        Middleware::requireRole('admin');
        if (!$id) $this->redirect('invoice');

        try {
            // Xóa member_packages liên quan trước (nếu có)
            $invoice = $this->invoiceModel->findById($id);
            if ($invoice && $invoice->package_id) {
                $db = Database::getInstance();
                $db->query("DELETE FROM member_packages WHERE member_id = :mid AND package_id = :pid");
                $db->bind(':mid', $invoice->member_id);
                $db->bind(':pid', $invoice->package_id);
                $db->execute();
            }

            $this->invoiceModel->delete($id);
            Session::flash('success', 'Đã xóa hóa đơn #' . $id . ' thành công.', 'success');
        } catch (\Exception $e) {
            Session::flash('error', 'Không thể xóa hóa đơn. Lỗi: ' . $e->getMessage(), 'danger');
        }
        $this->redirect('invoice');
    }
}
