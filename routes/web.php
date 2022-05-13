<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OperatorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', [App\Http\Controllers\HomeController::class, 'credit']);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
// Route::get('/app', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/daftar', [App\Http\Controllers\Auth\RegisterController::class, 'daftar'])->name('daftar');
Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
Route::get('/langkah-peminjaman', [App\Http\Controllers\HomeController::class, 'langkahPeminjaman'])->name('langkahPeminjaman');
Route::get('/home/inventaris', [App\Http\Controllers\HomeController::class, 'inventaris'])->name('home.inventaris');
Route::get('/detail/{id}', [App\Http\Controllers\HomeController::class, 'detail'])->name('detail.barang');


Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Peminjaman delete
    Route::delete('/delete/{id}', [App\Http\Controllers\PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

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
            Route::post('/reset/{user}', [UserController::class, 'reset'])->name('reset');
            Route::put('/update/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
            Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');
            Route::post('/import-csv', [UserController::class, 'import'])->name('import');
            Route::get('/export-csv', [UserController::class, 'export'])->name('export');
            Route::get('/user-PDF', [App\Http\Controllers\UserController::class, 'userPdf'])->name('pdf');
        });

        // Roles
        Route::resource('roles', App\Http\Controllers\RolesController::class);

        // Operator
        Route::resource('operator', OperatorController::class);
        Route::get('/update/status/{user_id}/{status}', [OperatorController::class, 'updateStatus'])->name('sts');
        // Barang
        Route::resource('barang', App\Http\Controllers\BarangController::class);
        Route::get('laboratoirum/{data}', [App\Http\Controllers\BarangController::class, 'adminBarang'])->name('admin.barang');
        Route::get('/qr-code/{data}', [App\Http\Controllers\BarangController::class, 'qrcode'])->name('qrcode');
        Route::post('import-csv', [App\Http\Controllers\BarangController::class, 'import'])->name('import.barang');
        Route::get('export-csv/{data}', [App\Http\Controllers\BarangController::class, 'export'])->name('export.barang');
        Route::get('barang/PDF/{id}', [App\Http\Controllers\BarangController::class, 'barangPdf'])->name('barang.pdf');

        // Barang Rusak
        Route::get('damaged/barang', [App\Http\Controllers\BarangController::class, 'damaged'])->name('barang.damaged');
        Route::get('damaged/{data}', [App\Http\Controllers\BarangController::class, 'adminDamaged'])->name('admin.damaged');
        Route::get('add/damaged', [App\Http\Controllers\BarangController::class, 'createDamaged'])->name('damaged.create');
        Route::post('store/damaged', [App\Http\Controllers\BarangController::class, 'storeDamaged'])->name('damaged.store');
        Route::get('damaged/export-csv/{data}', [App\Http\Controllers\BarangController::class, 'damagedexport'])->name('damaged.export');
        Route::get('damaged/barang/PDF/{id}', [App\Http\Controllers\BarangController::class, 'damagedPdf'])->name('damaged.pdf');

        // Update Stock
        Route::get('stok/show', [App\Http\Controllers\BarangController::class, 'showStok'])->name('stok.show');
        Route::post('update/update', [App\Http\Controllers\BarangController::class, 'updateStok'])->name('stok.update');


        // Inventaris
        Route::resource('inventaris', App\Http\Controllers\InventarisController::class);
        Route::get('inventaris/add/{data}', [App\Http\Controllers\InventarisController::class, 'add'])->name('inventaris.add');
        Route::get('inventaris/kategori/{data}', [App\Http\Controllers\InventarisController::class, 'adminInventaris'])->name('admin.inventaris');
        Route::get('inventaris/export-csv/{data}', [App\Http\Controllers\InventarisController::class, 'export'])->name('export.inventaris');
        Route::get('/select', [App\Http\Controllers\InventarisController::class, 'select'])->name('select.inventaris');
        Route::get('/mutasi', [App\Http\Controllers\InventarisController::class, 'mutasi'])->name('mutasi');
        Route::get('mutasi/admin/{data}', [App\Http\Controllers\InventarisController::class, 'adminMutasi'])->name('admin.mutasi');
        Route::get('/PDF/{id}', [App\Http\Controllers\InventarisController::class, 'inventarisPdf'])->name('inventaris.pdf');
        Route::get('mutasi/export-csv/{data}/{status}', [App\Http\Controllers\InventarisController::class, 'mutasiExport'])->name('export.mutasi');
        Route::get('mutasi/exportpdf/{data}/{status}', [App\Http\Controllers\InventarisController::class, 'mutasiPdf'])->name('mutasi.pdf');

        // transaksi
        Route::get('/daftar-peminjaman', [App\Http\Controllers\PeminjamanController::class, 'index'])->name('daftar.peminjaman');
        Route::get('peminjaman/{data}', [App\Http\Controllers\PeminjamanController::class, 'adminPeminjaman'])->name('admin.peminjaman');
        Route::get('peminjaman/export-csv/{data}', [App\Http\Controllers\PeminjamanController::class, 'export'])->name('export.peminjaman');


        // pengajuan
        Route::get('/konfirmasi-pengajuan', [App\Http\Controllers\PeminjamanController::class, 'pengajuan'])->name('konfirmasi.pengajuan');
        Route::get('/pengajuan/show/{id}', [App\Http\Controllers\PeminjamanController::class, 'showPengajuan'])->name('show.pengajuan');
        Route::get('/konfirmasi/pengajuan/{id}/{date}', [App\Http\Controllers\PeminjamanController::class, 'pengajuanDetail'])->name('pengajuan.detail');

        // peminjaman
        Route::get('/konfirmasi-peminjaman', [App\Http\Controllers\PeminjamanController::class, 'peminjaman'])->name('konfirmasi.peminjaman');
        Route::get('/konfirmasi/peminjaman/{data}', [App\Http\Controllers\PeminjamanController::class, 'konfirmasiPeminjamanDetail'])->name('konfirmasi.peminjaman.detail');
        // Route::get('/peminjaman/create', [App\Http\Controllers\PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::get('/konfirmasi/show/{data}', [App\Http\Controllers\PeminjamanController::class, 'show'])->name('konfirmasi.peminjaman.show');
        Route::get('/konfirmasi/tolak', [App\Http\Controllers\PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');

        // update status transaksi
        Route::get('/konfirmasi/{id_peminjaman}/{status}/{barang_id}/{jumlah}/{user_id}', [App\Http\Controllers\PeminjamanController::class, 'konfirmasiStatus'])->name('konfirmasi.peminjaman.status');
        Route::get('/konfirmasi/status/{id}/{date}/{status}', [App\Http\Controllers\PeminjamanController::class, 'statusPeminjaman'])->name('konfirmasi.status');

        // pengembalian
        Route::get('/konfirmasi-pengembalian', [App\Http\Controllers\PeminjamanController::class, 'pengembalian'])->name('konfirmasi.pengembalian');
        Route::post('/update/all', [App\Http\Controllers\PeminjamanController::class, 'updateAll'])->name('status.update');

        // scan
        Route::get('/scan/{status}', [App\Http\Controllers\PeminjamanController::class, 'scan'])->name('scan');
        Route::get('/store/{id}/{status}', [App\Http\Controllers\PeminjamanController::class, 'scanStore'])->name('scan.store');

        // Persuratan
        Route::get('/persuratan', [App\Http\Controllers\PersuratanController::class, 'create'])->name('persuratan.create');
        Route::post('/persuratan/store', [App\Http\Controllers\PersuratanController::class, 'store'])->name('persuratan.store');
        Route::get('/persuratan/riwayat', [App\Http\Controllers\PersuratanController::class, 'riwayat'])->name('persuratan.riwayat');
        Route::get('/persuratan/konfirmasi', [App\Http\Controllers\PersuratanController::class, 'konfirmasi'])->name('persuratan.konfirmasi');
        Route::get('/persuratan/status/{id}/{status}', [App\Http\Controllers\PersuratanController::class, 'status'])->name('persuratan.status');
        Route::get('/persuratan/export-csv', [App\Http\Controllers\PersuratanController::class, 'suratExport'])->name('export.surat');
        Route::get('/persuratan/mutasi/exportpdf', [App\Http\Controllers\PersuratanController::class, 'suratPdf'])->name('surat.pdf');

        // Satuan
        Route::resource('satuan', App\Http\Controllers\SatuanController::class);

        // Kategori
        Route::resource('kategori', App\Http\Controllers\KategoriController::class);

        // Pengadaan
        Route::resource('pengadaan', App\Http\Controllers\PengadaanController::class);
    });


    // ----------------------Role Peminjam-----------------

    Route::group(['middleware' => ['role:peminjam']], function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/pem', [App\Http\Controllers\HomeController::class, 'pem'])->name('pem');
        Route::get('/cart', [App\Http\Controllers\KeranjangController::class, 'index'])->name('cart');
        Route::get('/cart/store/{id}', [App\Http\Controllers\KeranjangController::class, 'store'])->name('cart.store');
        Route::delete('/cart/delete/{id}', [App\Http\Controllers\KeranjangController::class, 'destroy'])->name('cart.destroy');
        Route::get('/form/pengajuan/{id}', [App\Http\Controllers\KeranjangController::class, 'pengajuan'])->name('form.pengajuan');
        Route::post('/checkout/{id}', [App\Http\Controllers\PeminjamanController::class, 'store'])->name('checkout');
        Route::post('/keranjang/update', [App\Http\Controllers\KeranjangController::class, 'update'])->name('keranjang.update');
        Route::get('/decrement', [App\Http\Controllers\KeranjangController::class, 'decrement'])->name('keranjang.dec');
        Route::get('/increment', [App\Http\Controllers\KeranjangController::class, 'increment'])->name('keranjang.inc');


        Route::get('/daftar/pinjaman', [App\Http\Controllers\HomeController::class, 'pinjaman'])->name('daftar.pinjaman');
        Route::get('/daftar/show/pinjaman/{date}', [App\Http\Controllers\HomeController::class, 'detailShow'])->name('peminjaman.show.detail');
        Route::get('/peminjaman/edit/{id}', [App\Http\Controllers\PeminjamanController::class, 'edit'])->name('peminjaman.edit');
        Route::get('/kembalikan', [App\Http\Controllers\PeminjamanController::class, 'kembalikan'])->name('kembalikan');
        Route::post('/peminjaman/update/{date}', [App\Http\Controllers\PeminjamanController::class, 'update'])->name('peminjaman.update');
        Route::get('/cetak-surat', [App\Http\Controllers\PeminjamanController::class, 'print'])->name('print');
        // Route::get('/surat-bebas', [App\Http\Controllers\PeminjamanController::class, 'suratBebas'])->name('suratBebas');
        Route::resource('surat', App\Http\Controllers\SuratController::class);
    });
});
