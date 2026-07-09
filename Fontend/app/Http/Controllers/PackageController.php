<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Display packages list with stats
     */
    public function index()
    {
        try {
            $packagesRes = $this->api->get('/Packages');
            $statsRes = $this->api->get('/Packages/stats');

            $packages = $packagesRes->successful() ? $packagesRes->json() : [];
            $stats = $statsRes->successful() ? $statsRes->json() : [
                'totalPackages' => 0, 'activePackages' => 0,
                'totalSubscriptions' => 0, 'activeSubscriptions' => 0,
                'totalRevenue' => 0, 'pendingRevenue' => 0
            ];

            return view('admin.packages.index', compact('packages', 'stats'));
        } catch (\Exception $e) {
            return view('admin.packages.index', [
                'packages' => [],
                'stats' => [
                    'totalPackages' => 0, 'activePackages' => 0,
                    'totalSubscriptions' => 0, 'activeSubscriptions' => 0,
                    'totalRevenue' => 0, 'pendingRevenue' => 0
                ]
            ])->with('error', 'Không thể kết nối đến API. ' . $e->getMessage());
        }
    }

    /**
     * Show create package form
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store new package via API
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        try {
            $response = $this->api->post('/Packages', [
                'name' => $request->name,
                'duration' => (int) $request->duration,
                'price' => (float) $request->price,
                'description' => $request->description,
                'features' => $request->features,
                'isActive' => $request->has('isActive'),
            ]);

            if ($response->successful()) {
                return redirect()->route('admin.packages')->with('success', 'Tạo gói tập thành công!');
            }

            $error = $response->json()['message'] ?? 'Lỗi không xác định từ API.';
            return back()->withInput()->with('error', $error);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi kết nối: ' . $e->getMessage());
        }
    }

    /**
     * Show package detail with subscription list
     */
    public function show($id)
    {
        try {
            $response = $this->api->get("/Packages/{$id}");
            if (!$response->successful()) {
                return redirect()->route('admin.packages')->with('error', 'Không tìm thấy gói tập.');
            }

            $package = $response->json();

            // Get members for subscription assignment
            $membersRes = $this->api->get('/Members');
            $members = $membersRes->successful() ? $membersRes->json() : [];

            return view('admin.packages.show', compact('package', 'members'));
        } catch (\Exception $e) {
            return redirect()->route('admin.packages')->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        try {
            $response = $this->api->get("/Packages/{$id}");
            if (!$response->successful()) {
                return redirect()->route('admin.packages')->with('error', 'Không tìm thấy gói tập.');
            }

            $package = $response->json();
            return view('admin.packages.edit', compact('package'));
        } catch (\Exception $e) {
            return redirect()->route('admin.packages')->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Update package
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        try {
            $response = $this->api->put("/Packages/{$id}", [
                'name' => $request->name,
                'duration' => (int) $request->duration,
                'price' => (float) $request->price,
                'description' => $request->description,
                'features' => $request->features,
                'isActive' => $request->has('isActive'),
            ]);

            if ($response->successful()) {
                return redirect()->route('admin.packages.show', $id)->with('success', 'Cập nhật gói tập thành công!');
            }

            return back()->withInput()->with('error', $response->json()['message'] ?? 'Lỗi cập nhật.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi kết nối: ' . $e->getMessage());
        }
    }

    /**
     * Delete package
     */
    public function destroy($id)
    {
        try {
            $response = $this->api->delete("/Packages/{$id}");
            if ($response->successful()) {
                return redirect()->route('admin.packages')->with('success', 'Xóa gói tập thành công!');
            }
            return back()->with('error', $response->json()['message'] ?? 'Không thể xóa gói tập.');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Toggle package active/inactive
     */
    public function toggle($id)
    {
        try {
            $response = $this->api->post("/Packages/{$id}/toggle");
            if ($response->successful()) {
                return back()->with('success', $response->json()['message'] ?? 'Cập nhật trạng thái thành công.');
            }
            return back()->with('error', 'Không thể thay đổi trạng thái.');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Create subscription (assign package to member)
     */
    public function assignSubscription(Request $request, $packageId)
    {
        $request->validate([
            'memberId' => 'required|integer',
            'paymentStatus' => 'required|string',
        ]);

        try {
            $response = $this->api->post('/Packages/subscriptions', [
                'memberId' => (int) $request->memberId,
                'packageId' => (int) $packageId,
                'startDate' => $request->startDate ?? now()->toISOString(),
                'paymentStatus' => $request->paymentStatus,
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Đăng ký gói tập cho hội viên thành công!');
            }

            return back()->with('error', $response->json()['message'] ?? 'Lỗi đăng ký.');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Cancel a subscription
     */
    public function cancelSubscription($subId)
    {
        try {
            $response = $this->api->delete("/Packages/subscriptions/{$subId}");
            if ($response->successful()) {
                return back()->with('success', 'Đã hủy đăng ký gói tập.');
            }
            return back()->with('error', 'Không thể hủy đăng ký.');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
