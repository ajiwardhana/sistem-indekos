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


Route::get('/', function () {
    return auth()->check() 
        ? redirect()->route('home') 
        : view('auth.login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('pembayaran', PembayaranController::class)
    ->middleware('auth');

// Route khusus untuk verifikasi
Route::post('/pembayaran/verify/{id}', [PembayaranController::class, 'verify'])
    ->name('pembayaran.verify')
    ->middleware(['auth', 'admin']);

// Grup route admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Route Kamar
    Route::resource('kamar', \App\Http\Controllers\Admin\KamarController::class);
    
    // Route lainnya
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/pembayaran', [AdminController::class, 'pembayaran'])->name('pembayaran');
    Route::get('/penyewaan', [AdminController::class, 'penyewaan'])->name('penyewaan');
    Route::get('/pengguna', [AdminController::class, 'pengguna'])->name('pengguna');
});

require __DIR__.'/auth.php';
