<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class AdminController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Hiển thị trang Admin Dashboard tổng quan
     */
    public function dashboard(Request $request)
    {
        $branch_id = $request->get('branch_id');

        try {
            $response = $this->api->get('/v1/Dashboard/stats', ['branchId' => $branch_id]);
            $stats = $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            \Log::error("Dashboard stats API error: " . $e->getMessage());
            $stats = null;
        }

        if (!$stats) {
            $stats = [
                'total_members' => 0,
                'monthly_revenue' => 0,
                'today_classes' => 0,
                'medical_alerts' => 0
            ];
        }

        // Lấy danh sách chi nhánh cho selector
        try {
            $branchResponse = $this->api->get('/v1/Branches');
            $branches = $branchResponse->successful() ? $branchResponse->json() : [];
        } catch (\Exception $e) {
            \Log::error("Branches API error in dashboard: " . $e->getMessage());
            $branches = [];
        }

        $kpi = [
            'total_members' => data_get($stats, 'total_members') ?? data_get($stats, 'TotalMembers') ?? data_get($stats, 'totalMembers') ?? 0,
            'monthly_revenue' => data_get($stats, 'monthly_revenue') ?? data_get($stats, 'MonthlyRevenue') ?? data_get($stats, 'monthlyRevenue') ?? 0,
            'today_classes' => data_get($stats, 'today_classes') ?? data_get($stats, 'TodayClasses') ?? data_get($stats, 'todayClasses') ?? 0,
            'medical_alerts' => data_get($stats, 'medical_alerts') ?? data_get($stats, 'MedicalAlerts') ?? data_get($stats, 'medicalAlerts') ?? 0
        ];

        $recent_alerts = [
            [
                'member' => 'Trần Văn A', 
                'issue' => 'Nhịp tim > 185 bpm (Vượt ngưỡng an toàn)', 
                'time' => '5 phút trước', 
                'status' => 'critical'
            ],
            [
                'member' => 'Lê Thị B', 
                'issue' => 'SpO2 < 92% (Tụt oxy trong máu)', 
                'time' => '12 phút trước', 
                'status' => 'critical'
            ],
            [
                'member' => 'Nguyễn Văn C', 
                'issue' => 'Sai tư thế tập luyện (Squat sai lưng)', 
                'time' => '1 giờ trước', 
                'status' => 'warning'
            ],
        ];

        return view('admin.dashboard', compact('kpi', 'recent_alerts', 'branches'));
    }

    /**
     * Hiển thị trang Quản lý Chi nhánh (Super Admin Only)
     */
    public function branches()
    {
        if (session('user_role') !== 'Super Admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        // Gọi API Backend .NET để lấy danh sách chi nhánh
        $response = $this->api->get('/v1/Branches');
        $branches = $response->successful() ? $response->json() : [];

        $mgrResponse = $this->api->get('/v1/Branches/managers');
        $managers = $mgrResponse->successful() ? $mgrResponse->json() : [];

        return view('admin.branches', compact('branches', 'managers'));
    }

    /**
     * Thay đổi trạng thái Bật/Tắt của Chi nhánh
     */
    public function toggleBranch($id)
    {
        $response = $this->api->put("/v1/Branches/{$id}/toggle", []);
        
        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['message' => 'Lỗi kết nối API Backend'], 500);
    }

    /**
     * Thêm mới Chi nhánh
     */
    public function storeBranch(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $payload = [
            'Name' => $request->name,
            'Address' => $request->address,
            'Phone' => $request->phone,
            'ManagerId' => $request->manager_id ? (int)$request->manager_id : null,
            'IsActive' => $request->has('is_active'),
        ];

        $response = $this->api->post('/v1/Branches', $payload);

        if ($response->successful()) {
            return redirect()->route('admin.branches')->with('success', 'Thêm chi nhánh thành công!');
        }

        return redirect()->back()->with('error', 'Lỗi: ' . ($response->json()['message'] ?? 'Không thể lưu dữ liệu!'));
    }

    /**
     * Cập nhật Chi nhánh
     */
    public function updateBranch(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $payload = [
            'Name' => $request->name,
            'Address' => $request->address,
            'Phone' => $request->phone,
            'ManagerId' => $request->manager_id ? (int)$request->manager_id : null,
            'IsActive' => $request->has('is_active'),
        ];

        $response = $this->api->put("/v1/Branches/{$id}", $payload);

        if ($response->successful()) {
            return redirect()->route('admin.branches')->with('success', 'Cập nhật chi nhánh thành công!');
        }

        return redirect()->back()->with('error', 'Lỗi: ' . ($response->json()['message'] ?? 'Không thể cập nhật!'));
    }

    /**
     * Xóa Chi nhánh
     */
    public function deleteBranch($id)
    {
        $response = $this->api->delete("/v1/Branches/{$id}");

        if ($response->successful()) {
            return redirect()->route('admin.branches')->with('success', 'Đã xóa chi nhánh khỏi hệ thống!');
        }

        return redirect()->back()->with('error', 'Lỗi khi xóa dữ liệu!');
    }

    /**
     * Hiển thị trang Quản lý Nhân sự (Managers)
     */
    public function managers()
    {
        if (session('user_role') !== 'Super Admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $response = $this->api->get('/v1/Managers');
        $managers = $response->successful() ? $response->json() : [];

        $roleResponse = $this->api->get('/v1/Managers/roles');
        $roles = $roleResponse->successful() ? $roleResponse->json() : [];

        $branchResponse = $this->api->get('/v1/Branches');
        $branches = $branchResponse->successful() ? $branchResponse->json() : [];

        return view('admin.managers', compact('managers', 'roles', 'branches'));
    }

    /**
     * Thêm mới Quản lý
     */
    public function storeManager(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'password' => 'nullable|string|min:6',
        ]);

        $payload = [
            'FullName' => $request->full_name,
            'Email' => $request->email,
            'Password' => $request->password,
            'RoleId' => $request->role_id ? (int)$request->role_id : null,
            'BranchId' => $request->branch_id ? (int)$request->branch_id : null,
            'IsActive' => $request->has('is_active'),
        ];

        $response = $this->api->post('/v1/Managers', $payload);

        if ($response->successful()) {
            return redirect()->route('admin.managers')->with('success', 'Thêm quản lý mới thành công!');
        }

        return redirect()->back()->with('error', 'Lỗi: ' . ($response->json()['message'] ?? 'Không thể lưu dữ liệu!'));
    }

    /**
     * Cập nhật Quản lý
     */
    public function updateManager(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
        ]);

        $payload = [
            'FullName' => $request->full_name,
            'Email' => $request->email,
            'Password' => $request->password, 
            'RoleId' => $request->role_id ? (int)$request->role_id : null,
            'BranchId' => $request->branch_id ? (int)$request->branch_id : null,
            'IsActive' => $request->has('is_active'),
        ];

        $response = $this->api->put("/v1/Managers/{$id}", $payload);

        if ($response->successful()) {
            return redirect()->route('admin.managers')->with('success', 'Cập nhật thông tin thành công!');
        }

        return redirect()->back()->with('error', 'Lỗi: ' . ($response->json()['message'] ?? 'Không thể cập nhật!'));
    }

    /**
     * Xóa Quản lý
     */
    public function deleteManager($id)
    {
        $response = $this->api->delete("/v1/Managers/{$id}");

        if ($response->successful()) {
            return redirect()->route('admin.managers')->with('success', 'Đã xóa nhân sự khỏi hệ thống!');
        }

        return redirect()->back()->with('error', 'Lỗi khi xóa dữ liệu!');
    }
    /**
     * Thay đổi trạng thái Bật/Tắt của Nhân sự
     */
    public function toggleManager($id)
    {
        $response = $this->api->put("/v1/Managers/{$id}/toggle", []);
        
        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['message' => 'Lỗi kết nối API Backend'], 500);
    }
}
