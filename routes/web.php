<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KamarController as AdminKamarController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Penyewa\KamarController as PenyewaKamarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama (public)
Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Redirect setelah login berdasarkan role
Route::get('/home', function () {
    if (auth()->check()) {
        switch (auth()->user()->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'pemilik':
                return redirect()->route('pemilik.dashboard');
            case 'penyewa':
                return redirect()->route('penyewa.dashboard');
        }
    }
    return redirect()->route('login');
})->name('home');

/*
|--------------------------------------------------------------------------
| Routes Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::put('kamars/{id}/batalkan', [AdminKamarController::class, 'batalkan'])
    ->name('kamars.batalkan');

    Route::resource('kamars', AdminKamarController::class);
    Route::resource('users', UserController::class);
    Route::resource('admins', AdminController::class);

     // 🔥 Pembayaran
    Route::get('pembayarans', [AdminPembayaranController::class, 'index'])->name('pembayarans.index');
    Route::post('pembayarans/{id}/konfirmasi', [AdminPembayaranController::class, 'konfirmasi'])->name('pembayarans.konfirmasi');
    Route::post('pembayarans/{id}/tolak', [AdminPembayaranController::class, 'tolak'])->name('pembayarans.tolak');
    
    // Profil & Pengaturan
    Route::get('/profile', [ProfileController::class, 'adminProfile'])->name('profile');
    Route::get('/penghuni', [AdminController::class, 'manajemenPenghuni'])->name('penghuni');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/keluhan', fn() => view('admin.keluhan.index'))->name('keluhan.index');
});

/*
|--------------------------------------------------------------------------
| Routes Penyewa
|--------------------------------------------------------------------------
*/
Route::prefix('penyewa')->name('penyewa.')->middleware(['auth', 'role:penyewa'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Penyewa\DashboardController::class, 'index'])
        ->name('dashboard');

    // Kamar
    Route::get('/kamars', [App\Http\Controllers\Penyewa\KamarController::class, 'index'])
        ->name('kamar.index');
    Route::get('/kamars/{kamar}/sewa', [App\Http\Controllers\Penyewa\KamarController::class, 'sewa'])
        ->name('kamars.sewa');
    Route::post('/kamars/{kamar}/sewa', [App\Http\Controllers\Penyewa\KamarController::class, 'storeSewa'])
        ->name('kamar.store-sewa');
    
    // Pembayaran
    Route::get('pembayarans', [\App\Http\Controllers\Penyewa\PembayaranController::class, 'index'])
        ->name('pembayarans.index');

    // 🔥 ini route tambahan supaya cocok sama controller kamu
    Route::post('pembayarans/{id}/upload-bukti', [\App\Http\Controllers\Penyewa\PembayaranController::class, 'uploadBukti'])
        ->name('pembayarans.uploadBukti');
});

/*
|--------------------------------------------------------------------------
| Routes Pemilik
|--------------------------------------------------------------------------
*/
Route::prefix('pemilik')->name('pemilik.')->middleware(['auth', 'role:pemilik'])->group(function () {
    Route::get('/dashboard', fn() => view('pemilik.dashboard'))->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Routes Edit Profile (All Roles)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});