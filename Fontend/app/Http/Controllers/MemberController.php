<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Danh sách hội viên
     */
    public function index(Request $request)
    {
        $params = [
            'branchId' => $request->get('branchId'),
            'status' => $request->get('status'),
            'search' => $request->get('search'),
        ];

        // Lấy danh sách hội viên từ API
        $response = $this->api->get('/Members', $params);
        $members = $response->successful() ? $response->json() : [];

        // Lấy danh sách chi nhánh để hiển thị bộ lọc
        $branchResponse = $this->api->get('/v1/Branches');
        $branches = $branchResponse->successful() ? $branchResponse->json() : [];

        return view('admin.members.index', compact('members', 'branches'));
    }

    /**
     * Chi tiết hội viên & Chỉ số sức khỏe AI
     */
    public function show($id)
    {
        $response = $this->api->get("/Members/{$id}");
        if (!$response->successful()) {
            return redirect()->route('admin.members')->with('error', 'Không tìm thấy thông tin hội viên!');
        }

        $data = $response->json();
        $member = $data;
        $history = $data['healthMetricsHistory'] ?? [];

        return view('admin.members.show', compact('member', 'history'));
    }

    /**
     * Form thêm mới hội viên
     */
    public function create()
    {
        $branchResponse = $this->api->get('/v1/Branches');
        $branches = $branchResponse->successful() ? $branchResponse->json() : [];

        return view('admin.members.create', compact('branches'));
    }

    /**
     * Lưu hội viên mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|string',
            'dateOfBirth' => 'nullable|date',
            'height' => 'nullable|numeric|min:50|max:250',
            'weight' => 'nullable|numeric|min:20|max:200',
            'bodyFat' => 'nullable|numeric|min:1|max:60',
        ]);

        $payload = [
            'Email' => $request->email,
            'Password' => $request->password,
            'FullName' => $request->fullName,
            'Phone' => $request->phone,
            'BranchId' => $request->branchId ? (int)$request->branchId : null,
            'DateOfBirth' => $request->dateOfBirth,
            'Gender' => $request->gender,
            'Height' => $request->height ? (float)$request->height : null,
            'Weight' => $request->weight ? (float)$request->weight : null,
            'BodyFat' => $request->bodyFat ? (float)$request->bodyFat : null,
            'Address' => $request->address,
            'EmergencyContact' => $request->emergencyContact,
            'EmergencyPhone' => $request->emergencyPhone,
            'Nationality' => $request->nationality,
            'IdCard' => $request->idCard,
            'PtSessions' => $request->ptSessions ? (int)$request->ptSessions : 0,
            'Notes' => $request->notes,
        ];

        $response = $this->api->post('/Members', $payload);

        if ($response->successful()) {
            return redirect()->route('admin.members')->with('success', 'Thêm mới hội viên thành công!');
        }

        $errorMessage = $response->json()['message'] ?? 'Không thể lưu dữ liệu hội viên!';
        return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $errorMessage);
    }

    /**
     * Form chỉnh sửa hội viên
     */
    public function edit($id)
    {
        $response = $this->api->get("/Members/{$id}");
        if (!$response->successful()) {
            return redirect()->route('admin.members')->with('error', 'Không tìm thấy thông tin hội viên!');
        }

        $member = $response->json();

        $branchResponse = $this->api->get('/v1/Branches');
        $branches = $branchResponse->successful() ? $branchResponse->json() : [];

        return view('admin.members.edit', compact('member', 'branches'));
    }

    /**
     * Cập nhật thông tin hội viên
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'fullName' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|string',
            'dateOfBirth' => 'nullable|date',
            'height' => 'nullable|numeric|min:50|max:250',
            'weight' => 'nullable|numeric|min:20|max:200',
            'bodyFat' => 'nullable|numeric|min:1|max:60',
            'status' => 'required|string',
        ]);

        $payload = [
            'FullName' => $request->fullName,
            'Phone' => $request->phone,
            'BranchId' => $request->branchId ? (int)$request->branchId : null,
            'IsActive' => $request->has('isActive'),
            'DateOfBirth' => $request->dateOfBirth,
            'Gender' => $request->gender,
            'Height' => $request->height ? (float)$request->height : null,
            'Weight' => $request->weight ? (float)$request->weight : null,
            'BodyFat' => $request->bodyFat ? (float)$request->bodyFat : null,
            'Address' => $request->address,
            'EmergencyContact' => $request->emergencyContact,
            'EmergencyPhone' => $request->emergencyPhone,
            'Nationality' => $request->nationality,
            'IdCard' => $request->idCard,
            'PtSessions' => $request->ptSessions ? (int)$request->ptSessions : 0,
            'Notes' => $request->notes,
            'Status' => $request->status,
        ];

        $response = $this->api->put("/Members/{$id}", $payload);

        if ($response->successful()) {
            return redirect()->route('admin.members')->with('success', 'Cập nhật thông tin hội viên thành công!');
        }

        $errorMessage = $response->json()['message'] ?? 'Không thể cập nhật thông tin hội viên!';
        return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $errorMessage);
    }

    /**
     * Xóa hội viên
     */
    public function destroy($id)
    {
        $response = $this->api->delete("/Members/{$id}");

        if ($response->successful()) {
            return redirect()->route('admin.members')->with('success', 'Đã xóa hội viên khỏi hệ thống thành công!');
        }

        return redirect()->route('admin.members')->with('error', 'Lỗi khi xóa hội viên!');
    }

    /**
     * Ghi nhận chỉ số đo lường sức khỏe mới (BMI/BMR/Nhịp tim...)
     */
    public function recordMetrics(Request $request, $id)
    {
        $request->validate([
            'height' => 'required|numeric|min:50|max:250',
            'weight' => 'required|numeric|min:20|max:200',
            'bodyFat' => 'nullable|numeric|min:1|max:60',
            'heartRate' => 'nullable|integer|min:30|max:220',
            'spo2' => 'nullable|numeric|min:50|max:100',
        ]);

        $payload = [
            'Height' => (float)$request->height,
            'Weight' => (float)$request->weight,
            'BodyFat' => $request->bodyFat ? (float)$request->bodyFat : null,
            'HeartRate' => $request->heartRate ? (int)$request->heartRate : null,
            'SpO2' => $request->spo2 ? (float)$request->spo2 : null,
            'Notes' => $request->notes,
        ];

        $response = $this->api->post("/Members/{$id}/metrics", $payload);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Đã ghi nhận chỉ số đo lường sức khỏe mới thành công!');
        }

        $errorMessage = $response->json()['message'] ?? 'Lỗi khi ghi nhận chỉ số!';
        return redirect()->back()->with('error', 'Lỗi: ' . $errorMessage);
    }
}
