<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password.post');
Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('reset.password');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password.post');
Route::any('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return "Welcome to Dashboard! (User: " . session('user_name') . ")";
})->middleware('auth.api');

// Giao diện Admin Dashboard (Đã được bảo mật)
Route::prefix('admin')->middleware('auth.api')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/branches', [AdminController::class, 'branches'])->name('admin.branches');
    Route::post('/branches', [AdminController::class, 'storeBranch'])->name('admin.branches.store');
    Route::put('/branches/{id}', [AdminController::class, 'updateBranch'])->name('admin.branches.update');
    Route::delete('/branches/{id}', [AdminController::class, 'deleteBranch'])->name('admin.branches.delete');
    Route::post('/branches/{id}/toggle', [AdminController::class, 'toggleBranch'])->name('admin.branches.toggle');

    Route::get('/managers', [AdminController::class, 'managers'])->name('admin.managers');
    Route::post('/managers', [AdminController::class, 'storeManager'])->name('admin.managers.store');
    Route::put('/managers/{id}', [AdminController::class, 'updateManager'])->name('admin.managers.update');
    Route::delete('/managers/{id}', [AdminController::class, 'deleteManager'])->name('admin.managers.delete');
    Route::post('/managers/{id}/toggle', [AdminController::class, 'toggleManager'])->name('admin.managers.toggle');
});

