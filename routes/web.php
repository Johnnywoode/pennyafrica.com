<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('user.dashboard');
});

Route::prefix('')->name('user.')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');

    Route::get('transactions', [App\Http\Controllers\User\TransactionController::class, 'index'])->name('transactions');
    Route::post('transactions/search', [App\Http\Controllers\User\TransactionController::class, 'search'])->name('transactions.search');
});

Route::prefix(config('app.admin_path'))->name(config('app.admin_path') . '.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
    Route::post('users/search', [App\Http\Controllers\Admin\UserController::class, 'search'])->name('users.search');

    Route::get('transactions', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions');
    Route::post('transactions/search', [App\Http\Controllers\Admin\TransactionController::class, 'search'])->name('transactions.search');
});

Route::prefix('sandbox')->name('sandbox.')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\SandboxController::class, 'index'])->name('dashboard');
});






// Auth Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('post_login');

Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('post_register');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');
