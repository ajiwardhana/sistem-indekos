<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

// Dashboard utama
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Admin Routes
Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
// Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin')->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
//     Route::resource('kost', KostController::class);
//     Route::resource('kamar', KamarController::class);
//     Route::resource('penyewa', PenyewaController::class);
//     Route::resource('pembayaran', PembayaranController::class);
//     Route::resource('penyewaan', PenyewaanController::class);
// });

// User Routes
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});