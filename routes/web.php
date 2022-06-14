<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PersuratanController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\KeranjangController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'credit']);
// Route::get('/', [HomeController::class, 'index']);
Route::get('/app', [HomeController::class, 'index']);
Route::get('/daftar', [App\Http\Controllers\Auth\RegisterController::class, 'daftar'])->name('daftar');
Route::get('/daftar-barang', [HomeController::class, 'daftarBarang'])->name('search');
Route::get('/langkah-peminjaman', [HomeController::class, 'langkahPeminjaman'])->name('langkahPeminjaman');
Route::get('/home/inventaris', [HomeController::class, 'inventaris'])->name('home.inventaris');
Route::get('/detail/{id}', [HomeController::class, 'detailBarang'])->name('detail.barang');
Route::get('/verifikasi/surat-bebas/{kode}', [SuratController::class, 'cekSuratBebas']);
Route::get('/verifikasi/surat-peminjaman/_{kode}', [SuratController::class, 'cekSuratPeminjaman']);


Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Peminjaman delete
    Route::delete('/delete/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    // Detail Riwayat
    Route::get('/peminjaman/detail/riwayat', [HomeController::class, 'riwayatDetail'])->name('riwayat.detail');

    // Profile Routes
    Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'getProfile'])->name('detail');
        Route::post('/update', [DashboardController::class, 'updateProfile'])->name('update');
        Route::post('/update/ktm', [DashboardController::class, 'updateKTM'])->name('ktm');
        Route::post('/update/foto', [DashboardController::class, 'updateFoto'])->name('foto');
        Route::post('/change-password', [DashboardController::class, 'changePassword'])->name('change-password');
    });

    // Surat
    Route::resource('surat', App\Http\Controllers\SuratController::class);


    // ---------------------------Role Admin atau Operator--------------------------
    Route::group(['middleware' => ['role:admin|operator embedded|operator rpl|operator jarkom|operator mulmed']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Users 
        Route::middleware('auth')->prefix('pengguna')->name('users.')->group(function () {
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
            Route::get('/user-PDF', [UserController::class, 'userPdf'])->name('pdf');
        });

        // Roles
        Route::resource('roles', App\Http\Controllers\RolesController::class);

        // Operator
        Route::resource('operator', OperatorController::class);
        Route::get('/update/status/{user_id}/{status}', [OperatorController::class, 'updateStatus'])->name('sts');

        // Barang
        Route::resource('barang', App\Http\Controllers\BarangController::class);
        Route::get('laboratoirum/{data}', [BarangController::class, 'adminBarang'])->name('admin.barang');
        Route::get('/qr-code/{data}', [BarangController::class, 'qrcode'])->name('qrcode');
        Route::post('import-csv', [BarangController::class, 'import'])->name('import.barang');
        Route::get('export-csv/{data}', [BarangController::class, 'export'])->name('export.barang');
        Route::get('barang/PDF/{id}', [BarangController::class, 'barangPdf'])->name('barang.pdf');

        // Barang Rusak
        Route::get('damaged/barang', [BarangController::class, 'damaged'])->name('barang.damaged');
        Route::get('damaged/{data}', [BarangController::class, 'adminDamaged'])->name('admin.damaged');
        Route::get('add/damaged', [BarangController::class, 'createDamaged'])->name('damaged.create');
        Route::post('store/damaged', [BarangController::class, 'storeDamaged'])->name('damaged.store');
        Route::get('edit/damaged/{id}', [BarangController::class, 'editDamaged'])->name('damaged.edit');
        Route::post('update/damaged', [BarangController::class, 'updateDamaged'])->name('damaged.update');
        Route::get('damaged/export-csv/{data}', [BarangController::class, 'damagedexport'])->name('damaged.export');
        Route::get('damaged/barang/PDF/{id}', [BarangController::class, 'damagedPdf'])->name('damaged.pdf');

        // Update Stock
        Route::get('stok/show', [BarangController::class, 'showStok'])->name('stok.show');
        Route::post('update/update', [BarangController::class, 'updateStok'])->name('stok.update');

        // Barang Dipinjam
        Route::get('/barang-dipinjam', [BarangController::class, 'barangDipinjam'])->name('barang.dipinjam');
        Route::get('/barang-dipinjam/ajax', [BarangController::class, 'dipinjamAjax'])->name('dipinjam.ajax');

        // Inventaris
        Route::resource('inventaris', InventarisController::class);
        Route::get('inventaris/add/{data}', [InventarisController::class, 'add'])->name('inventaris.add');
        Route::get('inventaris/kategori/{data}', [InventarisController::class, 'adminInventaris'])->name('admin.inventaris');
        Route::get('inventaris/export-csv/{data}', [InventarisController::class, 'export'])->name('export.inventaris');
        Route::get('/select', [InventarisController::class, 'select'])->name('select.inventaris');
        Route::get('/mutasi', [InventarisController::class, 'mutasi'])->name('mutasi');
        Route::get('mutasi/admin/{data}', [InventarisController::class, 'adminMutasi'])->name('admin.mutasi');
        Route::get('/PDF/{id}', [InventarisController::class, 'inventarisPdf'])->name('inventaris.pdf');
        Route::get('mutasi/export-csv/{data}/{status}', [InventarisController::class, 'mutasiExport'])->name('export.mutasi');
        Route::get('mutasi/exportpdf/{data}/{status}', [InventarisController::class, 'mutasiPdf'])->name('mutasi.pdf');


        // pengajuan
        Route::get('/konfirmasi-pengajuan', [PeminjamanController::class, 'pengajuan'])->name('konfirmasi.pengajuan');
        Route::get('/pengajuan/show/{id}', [PeminjamanController::class, 'showPengajuan'])->name('show.pengajuan');
        Route::get('/konfirmasi/pengajuan/{id}/{kode}', [PeminjamanController::class, 'pengajuanDetail'])->name('pengajuan.detail');

        // peminjaman
        Route::get('/konfirmasi-peminjaman', [PeminjamanController::class, 'peminjaman'])->name('konfirmasi.peminjaman');
        Route::get('/peminjaman/show/{id}', [PeminjamanController::class, 'showPeminjaman'])->name('show.peminjaman');
        Route::get('/konfirmasi/peminjaman/{data}', [PeminjamanController::class, 'konfirmasiPeminjamanDetail'])->name('konfirmasi.peminjaman.detail');
        Route::get('/konfirmasi/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
        Route::get('/konfirmasi/status/{id}/{kode}/{status}', [PeminjamanController::class, 'statusPeminjaman'])->name('konfirmasi.status');

        // scan
        Route::get('/scan-pengembalian', [PeminjamanController::class, 'scanPengembalian'])->name('scan.pengembalian');
        Route::get('/store/{id}', [PeminjamanController::class, 'scanStore'])->name('scan.store');

        // Riwayat peminjaman
        Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'index'])->name('daftar.riwayat');
        Route::get('peminjaman/export-csv/{data}', [PeminjamanController::class, 'export'])->name('export.peminjaman');

        // Persuratan
        Route::get('/persuratan', [PersuratanController::class, 'create'])->name('persuratan.create');
        Route::post('/persuratan/store', [PersuratanController::class, 'store'])->name('persuratan.store');
        Route::get('/persuratan/riwayat', [PersuratanController::class, 'riwayat'])->name('persuratan.riwayat');
        Route::get('/persuratan/konfirmasi', [PersuratanController::class, 'konfirmasi'])->name('persuratan.konfirmasi');
        Route::get('/persuratan/status/{id}/{status}', [PersuratanController::class, 'status'])->name('persuratan.status');
        Route::get('/persuratan/export-csv', [PersuratanController::class, 'suratExport'])->name('export.surat');
        Route::get('/persuratan/mutasi/exportpdf', [PersuratanController::class, 'suratPdf'])->name('surat.pdf');

        // Satuan
        Route::resource('satuan', App\Http\Controllers\SatuanController::class);

        // Kategori
        Route::resource('kategori', App\Http\Controllers\KategoriController::class);

        // Pengadaan
        Route::resource('pengadaan', App\Http\Controllers\PengadaanController::class);
    });


    // ----------------------Role Peminjam-----------------

    Route::group(['middleware' => ['role:peminjam']], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/cart', [KeranjangController::class, 'index'])->name('cart');
        Route::get('/cart/store/{id}', [KeranjangController::class, 'store'])->name('cart.store');
        Route::delete('/cart/delete/{id}', [KeranjangController::class, 'destroy'])->name('cart.destroy');
        Route::post('/checkout/store', [PeminjamanController::class, 'checkout'])->name('pengajuan.form');
        Route::get('/decrement/{status}', [KeranjangController::class, 'decrement'])->name('keranjang.dec');
        Route::get('/increment/{status}', [KeranjangController::class, 'increment'])->name('keranjang.inc');
        Route::get('/cart/selected', [KeranjangController::class, 'cartSelected'])->name('cart.selected');
        // Peminjaman
        Route::get('/daftar/pinjaman', [HomeController::class, 'daftarPeminjaman'])->name('daftar.pinjaman');
        Route::get('/daftar/peminjaman/detail/{id}', [PeminjamanController::class, 'peminjamanDetail'])->name('peminjaman.detail');
        Route::post('/peminjaman/update/{date}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
        Route::get('/peminjaman/edit/{id}', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
        Route::get('/cetak-surat', [PeminjamanController::class, 'print'])->name('print');
        Route::get('/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('kembalikan');
        // Riwayat Peminjaman
        Route::get('/filter/riwayat/peminjaman/{kategori}', [HomeController::class, 'riwayatPeminjaman'])->name('riwayat.peminjaman');
    });
});
