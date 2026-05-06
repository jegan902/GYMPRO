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

        $errorData = $response->json();
        $errorMessage = $errorData['details'] ?? $errorData['message'] ?? 'Không thể tải thông tin hồ sơ!';
        
        \Log::error('Profile API Error: ' . $response->status() . ' - ' . $response->body());
        return redirect()->back()->with('error', $errorMessage . ' (Lỗi: ' . $response->status() . ')');
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
            'gender' => 'nullable|string|in:male,female,other',
            'nationality' => 'nullable|string|max:50',
            'dateOfBirth' => 'nullable|date',
            'address' => 'nullable|string|max:200',
            'idCard' => 'nullable|string|max:20',
            'Weight' => 'nullable|numeric',
            'Height' => 'nullable|numeric',
            'Bmi' => 'nullable|numeric',
            'BodyFat' => 'nullable|numeric',
        ]);

        $payload = [
            'FullName' => $request->fullName,
            'Phone' => $request->phone,
            'NewPassword' => $request->newPassword,
            'Gender' => $request->gender,
            'Nationality' => $request->nationality,
            'DateOfBirth' => $request->dateOfBirth,
            'Address' => $request->address,
            'IdCard' => $request->idCard,
            'Weight' => $request->filled('Weight') ? (float)$request->Weight : null,
            'Height' => $request->filled('Height') ? (float)$request->Height : null,
            'Bmi' => $request->filled('Bmi') ? (float)$request->Bmi : null,
            'BodyFat' => $request->filled('BodyFat') ? (float)$request->BodyFat : null,
        ];

        $client = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => 'Bearer ' . session('api_token'),
            'Accept' => 'application/json',
        ]);

        if ($request->hasFile('avatarFile')) {
            $response = $client->attach(
                'AvatarFile',
                file_get_contents($request->file('avatarFile')->getRealPath()),
                $request->file('avatarFile')->getClientOriginalName()
            )->post('http://127.0.0.1:5083/api/v1/Profile/update', $payload);
        } else {
            $response = $client->asForm()->post('http://127.0.0.1:5083/api/v1/Profile/update', $payload);
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
