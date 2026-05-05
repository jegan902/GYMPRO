<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class ProfileController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Hiển thị trang Hồ sơ cá nhân
     */
    public function index()
    {
        $response = $this->api->get('/v1/Profile');

        if ($response->successful()) {
            $user = $response->json();
            return view('admin.profile', compact('user'));
        }

        \Log::error('Profile API Error: ' . $response->status() . ' - ' . $response->body());
        return redirect()->back()->with('error', 'Không thể tải thông tin hồ sơ! Lỗi: ' . $response->status());
    }

    /**
     * Cập nhật Hồ sơ cá nhân
     */
    public function update(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'newPassword' => 'nullable|string|min:6|confirmed',
            'avatarFile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Weight' => 'nullable|numeric',
            'Height' => 'nullable|numeric',
            'Bmi' => 'nullable|numeric',
            'BodyFat' => 'nullable|numeric',
        ]);

        $headers = [
            'Authorization' => 'Bearer ' . session('api_token'),
            'Accept' => 'application/json',
        ];

        $client = \Illuminate\Support\Facades\Http::withHeaders($headers);

        $data = [
            ['name' => 'FullName', 'contents' => $request->fullName],
            ['name' => 'Phone', 'contents' => $request->phone ?? ''],
            ['name' => 'NewPassword', 'contents' => $request->newPassword ?? ''],
        ];

        if ($request->hasFile('avatarFile')) {
            $response = $client->attach(
                'AvatarFile',
                file_get_contents($request->file('avatarFile')->getRealPath()),
                $request->file('avatarFile')->getClientOriginalName()
            )->post('http://127.0.0.1:5083/api/v1/Profile/update', [
                        'FullName' => $request->fullName,
                        'Phone' => $request->phone,
                        'NewPassword' => $request->newPassword,
                        'Gender' => $request->gender,
                        'Nationality' => $request->nationality,
                        'DateOfBirth' => $request->dateOfBirth,
                        'Address' => $request->address,
                        'IdCard' => $request->idCard,
                        'Weight' => (float) $request->Weight,
                        'Height' => (float) $request->Height,
                        'Bmi' => (float) $request->Bmi,
                        'BodyFat' => (float) $request->BodyFat,
                    ]);
        } else {
            $response = $client->asForm()->post('http://127.0.0.1:5083/api/v1/Profile/update', [
                'FullName' => $request->fullName,
                'Phone' => $request->phone,
                'NewPassword' => $request->newPassword,
                'Gender' => $request->gender,
                'Nationality' => $request->nationality,
                'DateOfBirth' => $request->dateOfBirth,
                'Address' => $request->address,
                'IdCard' => $request->idCard,
                'Weight' => (float) $request->Weight,
                'Height' => (float) $request->Height,
                'Bmi' => (float) $request->Bmi,
                'BodyFat' => (float) $request->BodyFat,
            ]);
        }

        if ($response->successful()) {
            $data = $response->json();
            // Cập nhật lại thông tin trong Session
            session(['user_name' => $request->fullName]);
            if (isset($data['avatar'])) {
                session(['user_avatar' => $data['avatar']]);
            }

            return redirect()->back()->with('success', 'Cập nhật hồ sơ thành công!');
        }

        return redirect()->back()->with('error', 'Lỗi: ' . ($response->json()['message'] ?? 'Không thể cập nhật!'));
    }
}
