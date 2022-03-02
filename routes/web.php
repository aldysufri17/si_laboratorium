<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OperatorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/daftar', [App\Http\Controllers\Auth\RegisterController::class, 'daftar'])->name('daftar');
Route::get('/cari', [App\Http\Controllers\HomeController::class, 'cari'])->name('cari');

Auth::routes();

// ---------------------------Role Admin atau Operator--------------------------
Route::group(['middleware' => ['role:admin|operator']], function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Users 
    Route::middleware('auth')->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/detail/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
        Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');
    });
    // Profile Routes
    Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'getProfile'])->name('detail');
        Route::post('/update', [DashboardController::class, 'updateProfile'])->name('update');
        Route::post('/change-password', [DashboardController::class, 'changePassword'])->name('change-password');
    });
    // Roles
    Route::resource('roles', App\Http\Controllers\RolesController::class);
    // Operator
    Route::resource('operator', OperatorController::class);
    Route::get('/update/status/{user_id}/{status}', [OperatorController::class, 'updateStatus'])->name('sts');
    // Barang
    Route::resource('barang', App\Http\Controllers\BarangController::class);
    Route::get('damaged', [App\Http\Controllers\BarangController::class, 'damaged'])->name('damaged');
    // Stock
    Route::resource('stock', App\Http\Controllers\StockController::class);
    // peminjaman
    Route::get('/daftar-peminjaman', [App\Http\Controllers\PeminjamanController::class, 'index'])->name('daftar.peminjaman');
    Route::get('/konfirmasi-peminjaman', [App\Http\Controllers\PeminjamanController::class, 'peminjaman'])->name('konfirmasi.peminjaman');
    Route::get('/konfirmasi/peminjaman/{data}', [App\Http\Controllers\PeminjamanController::class, 'konfirmasiPeminjamanDetail'])->name('konfirmasi.peminjaman.detail');
    Route::get('/konfirmasi/{user_id}/{status}/{barang_id}/{jumlah}', [App\Http\Controllers\PeminjamanController::class, 'konfirmasiStatus'])->name('konfirmasi.peminjaman.status');
    Route::get('/konfirmasi-pengembalian', [App\Http\Controllers\PeminjamanController::class, 'pengembalian'])->name('konfirmasi.pengembalian');
    Route::get('/scan-pengembalian', [App\Http\Controllers\PeminjamanController::class, 'pengembalianScan'])->name('pengembalian.scan');
    Route::get('/scan/{lower}', [App\Http\Controllers\PeminjamanController::class, 'scan'])->name('scan');
});


// ----------------------Role Peminjam-----------------

Route::group(['middleware' => ['role:peminjam']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/checkout', [App\Http\Controllers\HomeController::class, 'create'])->name('create');
});
