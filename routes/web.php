<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

// Dashboard utama untuk semua user terautentikasi
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Route Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Route untuk Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
    Route::get('/kamar/{kamar}', [KamarController::class, 'show'])->name('kamar.show');
    Route::resource('kamar', KamarController::class);
    Route::resource('penyewaan', PenyewaanController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::get('/profile', [ProfileController::class, 'adminProfile'])->name('profile');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/keluhan', function () {
        return view('admin.keluhan.index');
    })->name('keluhan.index');
});

// Route untuk User Biasa
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
    Route::get('/kamar/{kamar}', [KamarController::class, 'show'])->name('kamar.show');
    Route::post('/kamar/{kamar}/sewa', [PenyewaanController::class, 'store'])->name('kamar.sewa');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Tambahkan route khusus user di sini
    Route::get('/pembayaran', [PembayaranController::class, 'userIndex'])->name('pembayaran.index');
    Route::get('/keluhan', function () {
        return view('user.keluhan.index');
    })->name('keluhan.index');
});