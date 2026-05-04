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
            
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => $response->json()['message'] ?? 'Đăng nhập thất bại.',
        ]);
    }

    public function logout()
    {
        Session::forget(['api_token', 'user_name', 'user_role']);
        return redirect('/login');
    }
}
