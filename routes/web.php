<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\PembayaranController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


use App\Http\Middleware\AdminMiddleware;
Route::get('/', function () {
    return view('welcome');
})->name('home');


// Route untuk admin
Route::prefix('admin')
     ->middleware(['auth', 'admin'])
     ->group(function () {
         Route::get('/dashboard', function () {
             return view('admin.dashboard');
         })->name('admin.dashboard');
     
    Route::resource('admin/kamar', KamarController::class);
    Route::resource('admin/penyewa', PenyewaController::class);
    Route::resource('admin/pembayaran', PembayaranController::class);
    Route::get('/admin/pembayaran/{pembayaran}/cetak', [PembayaranController::class, 'cetak'])->name('pembayaran.cetak');

    // Tambahkan route lainnya yang diperlukan untuk admin
});

// Route untuk pengguna biasa
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('user.dashboard');
});

Route::get('/check-kernel', function() {
    $kernel = app(\App\Http\Kernel::class);
    return [
        'middleware' => $kernel->getRouteMiddleware(),
        'loaded' => class_exists(\App\Http\Middleware\AdminMiddleware::class)
    ];
});


require __DIR__.'/auth.php';
