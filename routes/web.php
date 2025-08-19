<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;



use App\Http\Middleware\AdminMiddleware;
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route utama
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Route untuk login dan registrasi
Auth::routes(['register' => false]); // Nonaktifkan registrasi jika tidak diperlukan        

// Route untuk admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('kamar', 'App\Http\Controllers\Admin\KamarController');

    // Route Kamar
    route('admin.kamar.create');
    Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
    Route::get('/kamar/create', [KamarController::class, 'create'])->name('kamar.create');
    Route::post('/kamar', [KamarController::class, 'store'])->name('kamar.store');
    Route::get('/kamar/{kamar}/edit', [KamarController::class, 'edit'])->name('kamar.edit');
    Route::put('/kamar/{kamar}', [KamarController::class, 'update'])->name('kamar.update');
    Route::delete('/kamar/{kamar}', [KamarController::class, 'destroy'])->name('kamar.destroy');
    // Route Pembayaran
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/{pembayaran}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::put('/pembayaran/{pembayaran}/approve', [PembayaranController::class, 'approve'])->name('pembayaran.approve');
    Route::put('/pembayaran/{pembayaran}/reject', [PembayaranController::class, 'reject'])->name('pembayaran.reject');
});

// Route untuk pengguna biasa
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('user.dashboard');
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/create', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
});

Route::get('/check-kernel', function() {
    $kernel = app(\App\Http\Kernel::class);
    return [
        'middleware' => $kernel->getRouteMiddleware(),
        'loaded' => class_exists(\App\Http\Middleware\AdminMiddleware::class)
    ];
});

// Tambahkan route profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    // Route untuk dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Route untuk profil - gunakan array syntax yang benar
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Route home
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // ... route lainnya ...
});


require __DIR__.'/auth.php';
