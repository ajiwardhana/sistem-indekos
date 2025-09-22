<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\Admin\KamarController as AdminKamarController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Penyewa\PenyewaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Penyewa\KamarController as PenyewaKamarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Auth Routes (Tambahkan ini)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');
    
    Route::post('/register', [RegisteredUserController::class, 'store']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Redirect setelah login berdasarkan role
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

// Route untuk Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Resource routes
    Route::resource('kamar', AdminKamarController::class);
    Route::resource('users', UserController::class);
    
    // Route khusus lainnya
    Route::get('/profile', [ProfileController::class, 'adminProfile'])->name('profile');
    Route::get('/penghuni', [AdminController::class, 'manajemenPenghuni'])->name('penghuni');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    
    // Route untuk keluhan (placeholder)
    Route::get('/keluhan', function () {
        return view('admin.keluhan.index');
    })->name('keluhan.index');
});

// Route untuk Penyewa
Route::prefix('penyewa')->name('penyewa.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('penyewa.dashboard');
    })->name('dashboard');
    
    // Kamar routes untuk penyewa
    Route::get('/kamars', [PenyewaKamarController::class, 'index'])->name('kamar.index');
    Route::get('/kamars/{kamar}/sewa', [PenyewaKamarController::class, 'sewa'])->name('kamar.sewa');
    Route::post('/kamars/{kamar}/sewa', [PenyewaKamarController::class, 'storeSewa'])->name('kamar.store-sewa');
});

// Jika Anda memiliki route untuk Pemilik Kos
Route::prefix('pemilik')->name('pemilik.')->middleware(['auth', 'pemilik'])->group(function () {
    Route::get('/dashboard', function () {
        return view('pemilik.dashboard');
    })->name('dashboard');
    
    // Tambahkan route khusus pemilik di sini
});