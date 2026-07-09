<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/lang/{locale}', [HomeController::class, 'changeLanguage'])->name('lang.switch');

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
    if (in_array(session('user_role'), ['Super Admin', 'Branch Admin'])) {
        return redirect()->route('admin.dashboard');
    }
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

    // Equipments
    Route::get('/equipments', [EquipmentController::class, 'index'])->name('admin.equipments');
    Route::get('/equipments/create', [EquipmentController::class, 'create'])->name('admin.equipments.create');
    Route::get('/equipments/{id}', [EquipmentController::class, 'show'])->name('admin.equipments.show');
    Route::get('/equipments/{id}/edit', [EquipmentController::class, 'edit'])->name('admin.equipments.edit');
    Route::post('/equipments', [EquipmentController::class, 'store'])->name('admin.equipments.store');
    Route::patch('/equipments/{id}', [EquipmentController::class, 'update'])->name('admin.equipments.update');
    Route::delete('/equipments/{id}', [EquipmentController::class, 'destroy'])->name('admin.equipments.destroy');
    Route::post('/equipments/{id}/maintenance', [EquipmentController::class, 'maintenance'])->name('admin.equipments.maintenance');

    // Members
    Route::get('/members', [MemberController::class, 'index'])->name('admin.members');
    Route::get('/members/create', [MemberController::class, 'create'])->name('admin.members.create');
    Route::get('/members/{id}', [MemberController::class, 'show'])->name('admin.members.show');
    Route::get('/members/{id}/edit', [MemberController::class, 'edit'])->name('admin.members.edit');
    Route::post('/members', [MemberController::class, 'store'])->name('admin.members.store');
    Route::put('/members/{id}', [MemberController::class, 'update'])->name('admin.members.update');
    Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('admin.members.destroy');
    Route::post('/members/{id}/metrics', [MemberController::class, 'recordMetrics'])->name('admin.members.metrics');

    // Packages & Subscriptions
    Route::get('/packages', [PackageController::class, 'index'])->name('admin.packages');
    Route::get('/packages/create', [PackageController::class, 'create'])->name('admin.packages.create');
    Route::get('/packages/{id}', [PackageController::class, 'show'])->name('admin.packages.show');
    Route::get('/packages/{id}/edit', [PackageController::class, 'edit'])->name('admin.packages.edit');
    Route::post('/packages', [PackageController::class, 'store'])->name('admin.packages.store');
    Route::put('/packages/{id}', [PackageController::class, 'update'])->name('admin.packages.update');
    Route::delete('/packages/{id}', [PackageController::class, 'destroy'])->name('admin.packages.destroy');
    Route::post('/packages/{id}/toggle', [PackageController::class, 'toggle'])->name('admin.packages.toggle');
    Route::post('/packages/{packageId}/subscription', [PackageController::class, 'assignSubscription'])->name('admin.packages.subscription.assign');
    Route::delete('/subscriptions/{subId}', [PackageController::class, 'cancelSubscription'])->name('admin.packages.subscription.cancel');

    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
});

