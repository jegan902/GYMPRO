<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $response = $this->api->post('/auth/login', $credentials);

        if ($response->successful()) {
            $data = $response->json();
            Session::put('api_token', $data['token']);
            Session::put('user_name', $data['fullName']);
            Session::put('user_role', $data['role']);

            if (in_array($data['role'], ['Super Admin', 'Branch Admin'])) {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => $response->json()['message'] ?? 'Đăng nhập thất bại.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        $response = $this->api->post('/auth/register', $data);

        if ($response->successful()) {
            return redirect('/login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
        }

        $errorMessage = $response->json()['message'] ?? 'Đăng ký thất bại.';
        if (!$response->json() && $response->body()) {
            $errorMessage = "API Error: " . $response->status() . " - " . substr($response->body(), 0, 100);
        }

        return back()->withErrors([
            'email' => $errorMessage,
        ])->withInput();
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $data = $request->validate(['email' => 'required|email']);
        $response = $this->api->post('/auth/forgot-password', $data);

        if ($response->successful()) {
            return redirect()->route('reset.password', ['email' => $request->email])->with('success', 'Mã OTP đã được gửi đến email của bạn.');
        }

        return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống.']);
    }

    public function showResetPassword(Request $request)
    {
        return view('auth.reset-password', ['email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
            'newPassword' => 'required|string|min:6|confirmed',
        ]);

        $response = $this->api->post('/auth/reset-password', $data);

        if ($response->successful()) {
            return redirect('/login')->with('success', 'Mật khẩu đã được đổi thành công. Vui lòng đăng nhập.');
        }

        return back()->withErrors(['otp' => $response->json()['message'] ?? 'Mã OTP không hợp lệ.']);
    }

    public function logout()
    {
        Session::forget(['api_token', 'user_name', 'user_role']);
        return redirect('/login');
    }
}
