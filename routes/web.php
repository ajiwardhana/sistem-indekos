<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ProfileController as AuthProfileController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\PasswordController;


// Grup route untuk Admin
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('kamar', \App\Http\Controllers\Admin\KamarController::class);
    Route::resource('penyewaan', \App\Http\Controllers\Admin\PenyewaanController::class);
    Route::resource('pembayaran', \App\Http\Controllers\Admin\PembayaranController::class);
});

// Grup route untuk User Biasa
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('kamar', \App\Http\Controllers\KamarController::class)->only(['index', 'show']);
    Route::resource('penyewaan', \App\Http\Controllers\PenyewaanController::class);
});

require __DIR__.'/auth.php';
