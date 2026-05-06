<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use Illuminate\Support\Facades\Log;

class EquipmentController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Danh sách thiết bị
     */
    public function index(Request $request)
    {
        // Explicitly handle branchId to ensure 'All' (0) is respected
        $rawBranchId = $request->get('branchId');
        if ($rawBranchId === "" || $rawBranchId === null) {
            $branchId = $request->has('branchId') ? 0 : session('branch_id', 0);
        } else {
            $branchId = (int)$rawBranchId;
        }
        
        $params = [
            'status' => $request->get('status'),
            'category' => $request->get('category'),
            'search' => $request->get('search'),
            'page' => $request->get('page', 1),
            'pageSize' => $request->get('pageSize', 20),
            'branchId' => $branchId,
        ];

        Log::info('Equipment API Params:', $params);

        $response = $this->api->get('/v1/Equipments', $params);
        $data = $response->json();
        
        $equipments = $data['data'] ?? [];
        $pagination = [
            'totalCount' => $data['totalCount'] ?? $data['TotalCount'] ?? 0,
            'totalPages' => $data['totalPages'] ?? $data['TotalPages'] ?? 1,
            'currentPage' => $data['page'] ?? $data['Page'] ?? 1,
            'pageSize' => $data['pageSize'] ?? $data['PageSize'] ?? 20
        ];

        // Pass branchId to dashboard metrics too
        $metricsResponse = $this->api->get('/v1/Equipments/dashboard', ['branchId' => $branchId]);
        $metricsRaw = $metricsResponse->successful() ? ($metricsResponse->json()['data'] ?? []) : [];
        $metrics = [
            'totalEquipments' => $metricsRaw['totalEquipments'] ?? $metricsRaw['TotalEquipments'] ?? 0,
            'activeEquipments' => $metricsRaw['activeEquipments'] ?? $metricsRaw['ActiveEquipments'] ?? 0,
            'brokenEquipments' => $metricsRaw['brokenEquipments'] ?? $metricsRaw['BrokenEquipments'] ?? 0,
            'maintenanceOverdue' => $metricsRaw['maintenanceOverdue'] ?? $metricsRaw['MaintenanceOverdue'] ?? 0,
        ];

        // Lấy danh sách chi nhánh cho filters
        $branchResponse = $this->api->get('/v1/Branches');
        $branches = $branchResponse->successful() ? $branchResponse->json() : [];

        return view('admin.equipments', compact('equipments', 'metrics', 'branches', 'pagination'));
    }

    /**
     * Chi tiết thiết bị
     */
    public function show($id)
    {
        $response = $this->api->get("/v1/Equipments/{$id}");
        if (!$response->successful()) {
            return redirect()->route('admin.equipments')->with('error', 'Không tìm thấy thiết bị!');
        }

        $equipment = $response->json()['data'];
        return view('admin.equipment_detail', compact('equipment'));
    }

    /**
     * Form thêm mới
     */
    public function create()
    {
        $branchResponse = $this->api->get('/v1/Branches');
        $branches = $branchResponse->successful() ? $branchResponse->json() : [];

        return view('admin.equipment_form', compact('branches'));
    }

    /**
     * Lưu thiết bị mới
     */
    public function store(Request $request)
    {
        $payload = $request->all();
        
        // Xử lý file upload nếu có (Trong thực tế sẽ upload lên server C# hoặc lưu path)
        if ($request->hasFile('image')) {
            // Demo: Ở đây ta chỉ gửi payload, việc upload file phức tạp hơn 
            // Cần một API endpoint riêng để upload file và nhận URL
        }

        $response = $this->api->post('/v1/Equipments', $payload);

        if ($response->successful()) {
            return redirect()->route('admin.equipments')->with('success', 'Thêm thiết bị thành công!');
        }

        return redirect()->back()->withInput()->with('error', 'Lỗi: ' . ($response->json()['message'] ?? 'Không thể lưu dữ liệu!'));
    }

    /**
     * Form chỉnh sửa
     */
    public function edit($id)
    {
        $response = $this->api->get("/v1/Equipments/{$id}");
        if (!$response->successful()) {
            return redirect()->route('admin.equipments')->with('error', 'Không tìm thấy thiết bị!');
        }

        $equipment = $response->json()['data'];
        
        $branchResponse = $this->api->get('/v1/Branches');
        $branches = $branchResponse->successful() ? $branchResponse->json() : [];

        return view('admin.equipment_form', compact('equipment', 'branches'));
    }

    /**
     * Cập nhật thiết bị
     */
    public function update(Request $request, $id)
    {
        $payload = $request->all();
        $response = $this->api->patch("/v1/Equipments/{$id}", $payload);

        if ($response->successful()) {
            return redirect()->route('admin.equipments')->with('success', 'Cập nhật thiết bị thành công!');
        }

        return redirect()->back()->withInput()->with('error', 'Lỗi: ' . ($response->json()['message'] ?? 'Không thể cập nhật!'));
    }

    /**
     * Xóa thiết bị
     */
    public function destroy($id)
    {
        $response = $this->api->delete("/v1/Equipments/{$id}");
        
        if ($response->successful()) {
            return response()->json(['success' => true, 'message' => 'Đã xóa thiết bị!']);
        }

        return response()->json(['success' => false, 'message' => 'Lỗi khi xóa thiết bị!'], 500);
    }

    /**
     * Thêm lịch sử bảo trì
     */
    public function maintenance(Request $request, $id)
    {
        $payload = [
            'issue' => $request->issue,
            'repairAction' => $request->repair_action,
            'cost' => (float)$request->cost,
            'notes' => $request->notes,
            'repairedAt' => $request->repaired_at,
        ];

        $response = $this->api->post("/v1/Equipments/{$id}/maintenance", $payload);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Đã lưu lịch sử bảo trì!');
        }

        return redirect()->back()->with('error', 'Lỗi: ' . ($response->json()['message'] ?? 'Không thể lưu!'));
    }
}
