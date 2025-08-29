<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KamarController; // Untuk user
use App\Http\Controllers\Admin\KamarController as AdminKamarController; // Untuk admin
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Admin\AdminController as AdminAdminController;
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
    
    // GUNAKAN AdminKamarController untuk admin
    Route::resource('kamar', AdminKamarController::class);
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
    
    // Kamar routes
    Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
    Route::get('/kamar/{kamar}', [KamarController::class, 'show'])->name('kamar.show');
    
    // Penyewaan routes
    Route::resource('penyewaan', PenyewaanController::class);
    Route::get('/penyewaan', [PenyewaanController::class, 'index'])->name('penyewaan.index');
    Route::post('/kamar/{id}/sewa', [PenyewaanController::class, 'sewa'])->name('kamar.sewa');
    
    // ✅ PERBAIKI: Tambahkan route pembayaran yang benar
    Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
        Route::get('/', [PembayaranController::class, 'userIndex'])->name('index');
        
        Route::post('/store', [PembayaranController::class, 'store'])->name('store');
    });
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/keluhan', function () {
        return view('user.keluhan.index');
    })->name('keluhan.index');
});