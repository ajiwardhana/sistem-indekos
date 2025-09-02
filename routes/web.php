<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KamarController; // Untuk user
use App\Http\Controllers\Admin\KamarController as AdminKamarController; // Untuk admin
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Admin\AdminController as AdminAdminController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Penyewa\PenyewaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


Route::get('/home', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role === 'pemilik') {
            return redirect()->route('pemilik.dashboard');
        }
    }
    return redirect()->route('penyewa.dashboard');
})->name('home');


// Route Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Route untuk Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('kamar', 'Admin\KamarController');
    Route::resource('users', 'Admin\UserController');
    
    // GUNAKAN AdminKamarController untuk admin
    Route::resource('kamar', AdminKamarController::class);
    Route::resource('penyewaan', PenyewaanController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::resource('penyewaan', App\Http\Controllers\Admin\PenyewaanController::class);

    
    Route::get('/profile', [ProfileController::class, 'adminProfile'])->name('profile');
    Route::get('/penghuni', [AdminController::class, 'manajemPenghunienPenghuni'])->name('penghuni');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/keluhan', function () {
        return view('admin.keluhan.index');
    })->name('keluhan.index');
});

// Route untuk User Biasa
Route::prefix('penyewa')->name('penyewa.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('penyewa.dashboard');
    })->name('dashboard');
    
    Route::get('/kamars', 'Penyewa\KamarController@index')->name('kamar.index');
    Route::get('/kamars/{kamar}/sewa', 'Penyewa\KamarController@sewa')->name('kamar.sewa');
    Route::post('/kamars/{kamar}/sewa', 'Penyewa\KamarController@storeSewa')->name('kamar.store-sewa');
});

// Public routes
Route::get('/', function () {
    return view('welcome');
});