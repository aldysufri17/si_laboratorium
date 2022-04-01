<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OperatorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/daftar', [App\Http\Controllers\Auth\RegisterController::class, 'daftar'])->name('daftar');
Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
Route::get('/detail/{id}', [App\Http\Controllers\HomeController::class, 'detail'])->name('detail.barang');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'getProfile'])->name('detail');
        Route::post('/update', [DashboardController::class, 'updateProfile'])->name('update');
        Route::post('/update/ktm', [DashboardController::class, 'updateKTM'])->name('ktm');
        Route::post('/update/foto', [DashboardController::class, 'updateFoto'])->name('foto');
        Route::post('/change-password', [DashboardController::class, 'changePassword'])->name('change-password');
    });

    // ---------------------------Role Admin atau Operator--------------------------
    Route::group(['middleware' => ['role:admin|operator embedded|operator rpl|operator jarkom|operator mulmed']], function () {
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

        // Roles
        Route::resource('roles', App\Http\Controllers\RolesController::class);

        // Operator
        Route::resource('operator', OperatorController::class);
        Route::get('/update/status/{user_id}/{status}', [OperatorController::class, 'updateStatus'])->name('sts');

        // Barang
        Route::resource('barang', App\Http\Controllers\BarangController::class);
        Route::get('laboratoirum/{data}', [App\Http\Controllers\BarangController::class, 'adminBarang'])->name('admin.barang');
        Route::get('damaged', [App\Http\Controllers\BarangController::class, 'damaged'])->name('damaged');
        Route::get('/qr-code/{data}', [App\Http\Controllers\BarangController::class, 'qrcode'])->name('qrcode');

        // Inventaris
        Route::resource('inventaris', App\Http\Controllers\InventarisController::class);
        Route::get('add/{data}', [App\Http\Controllers\InventarisController::class, 'add'])->name('inventaris.add');
        Route::get('kategori/{data}', [App\Http\Controllers\InventarisController::class, 'adminInventaris'])->name('admin.inventaris');

        // peminjaman
        Route::get('/daftar-peminjaman', [App\Http\Controllers\PeminjamanController::class, 'index'])->name('daftar.peminjaman');
        Route::get('peminjaman/{data}', [App\Http\Controllers\PeminjamanController::class, 'adminPeminjaman'])->name('admin.peminjaman');
        Route::get('/peminjaman/create', [App\Http\Controllers\PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::get('/konfirmasi-pengajuan', [App\Http\Controllers\PeminjamanController::class, 'pengajuan'])->name('konfirmasi.pengajuan');
        Route::get('/konfirmasi/pengajuan/{data}', [App\Http\Controllers\PeminjamanController::class, 'pengajuanDetail'])->name('pengajuan.detail');
        Route::get('/konfirmasi-peminjaman', [App\Http\Controllers\PeminjamanController::class, 'peminjaman'])->name('konfirmasi.peminjaman');
        Route::get('/konfirmasi/peminjaman/{data}', [App\Http\Controllers\PeminjamanController::class, 'konfirmasiPeminjamanDetail'])->name('konfirmasi.peminjaman.detail');
        Route::get('/konfirmasi/{user_id}/{status}/{barang_id}/{jumlah}', [App\Http\Controllers\PeminjamanController::class, 'konfirmasiStatus'])->name('konfirmasi.peminjaman.status');
        Route::get('/konfirmasi-pengembalian', [App\Http\Controllers\PeminjamanController::class, 'pengembalian'])->name('konfirmasi.pengembalian');
        Route::get('/scan/{status}', [App\Http\Controllers\PeminjamanController::class, 'scan'])->name('scan');
        Route::get('/store/{id}/{status}', [App\Http\Controllers\PeminjamanController::class, 'scanStore'])->name('scan.store');

        // Persuratan
        Route::resource('surat', App\Http\Controllers\PersuratanController::class);
    });


    // ----------------------Role Peminjam-----------------

    Route::group(['middleware' => ['role:peminjam']], function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/cart', [App\Http\Controllers\BarangController::class, 'cart'])->name('cart');
        Route::get('/daftar/riwayat', [App\Http\Controllers\HomeController::class, 'riwayat'])->name('daftar.riwayat');
        Route::post('/peminjaman/store/{id}', [App\Http\Controllers\PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('/peminjaman/edit/{id}', [App\Http\Controllers\PeminjamanController::class, 'edit'])->name('peminjaman.edit');
        Route::post('/peminjaman/update/{id}', [App\Http\Controllers\PeminjamanController::class, 'update'])->name('peminjaman.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
        Route::get('/cetak-surat', [App\Http\Controllers\PeminjamanController::class, 'print'])->name('print');
    });
});
