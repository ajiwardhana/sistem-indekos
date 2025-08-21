<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard Routes untuk semua user
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Admin Routes Group
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])
        ->name('dashboard');
    
    // Kost Management
    Route::resource('kost', KostController::class);
    
    // Kamar Management
    Route::resource('kamar', KamarController::class);
    
    // Penyewa Management
    Route::resource('penyewa', PenyewaController::class);
    
    // Pembayaran Management
    Route::resource('pembayaran', PembayaranController::class);
    
    // Penyewaan Management
    Route::resource('penyewaan', PenyewaanController::class);
});

// User Routes (Non-Admin)
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])
        ->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';