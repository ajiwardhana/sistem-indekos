<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\PembayaranController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Route untuk admin
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('kamar', KamarController::class);
    Route::resource('penyewa', PenyewaController::class);
    Route::resource('pembayaran', PembayaranController::class);
    
});

// Route untuk pengguna biasa
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('user.dashboard');
});


require __DIR__.'/auth.php';
