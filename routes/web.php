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
    Route::resource('kamars', AdminKamarController::class);
    Route::resource('users', UserController::class);
    Route::resource('penyewa', PenyewaController::class);

     // 🔥 Pembayaran
    Route::get('/admin/pembayarans', [AdminPembayaranController::class, 'index'])->name('admin.pembayarans.index');
    Route::post('/admin/pembayarans/{id}/konfirmasi', [AdminPembayaranController::class, 'konfirmasi'])->name('admin.pembayarans.konfirmasi');
    Route::post('/admin/pembayarans/{id}/tolak', [AdminPembayaranController::class, 'tolak'])->name('admin.pembayarans.tolak');

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
    Route::get('/dashboard', [App\Http\Controllers\Penyewa\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/kamars', [PenyewaKamarController::class, 'index'])->name('kamar.index');
    Route::get('/kamars/{kamar}/sewa', [PenyewaKamarController::class, 'sewa'])->name('kamar.sewa');
    Route::post('/kamars/{kamar}/sewa', [PenyewaKamarController::class, 'storeSewa'])->name('kamar.store-sewa');
    
    // Pembayaran
    Route::get('pembayarans', [\App\Http\Controllers\Penyewa\PembayaranController::class, 'index'])
        ->name('pembayaran.index');
    Route::post('pembayarans/{id}/bayar', [\App\Http\Controllers\Penyewa\PembayaranController::class, 'bayar'])
        ->name('pembayaran.bayar');
    Route::post('/pembayaran/{pembayaran}/upload', [\App\Http\Controllers\Penyewa\PembayaranController::class, 'uploadBukti'])->name('pembayaran.upload');
});

/*
|--------------------------------------------------------------------------
| Routes Pemilik
|--------------------------------------------------------------------------
*/
Route::prefix('pemilik')->name('pemilik.')->middleware(['auth', 'role:pemilik'])->group(function () {
    Route::get('/dashboard', fn() => view('pemilik.dashboard'))->name('dashboard');
});
