<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfirmPasswordController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/products_mgmt.php';
require __DIR__.'/finance.php';
require __DIR__.'/settings.php';
require __DIR__.'/orders.php';
require __DIR__.'/sale.php';
require __DIR__.'/reports.php';

// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/confirm-password', [ConfirmPasswordController::class, 'showConfirmPasswordForm'])->name('confirm-password');
    Route::post('/confirm-password', [ConfirmPasswordController::class, 'confirmPassword']);

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

});
