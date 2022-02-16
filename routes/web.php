<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/daftar', [App\Http\Controllers\Auth\RegisterController::class, 'daftar'])->name('daftar');
Route::get('/cek', [App\Http\Controllers\Auth\RegisterController::class, 'cek'])->name('cek');
Route::get('/cari', [App\Http\Controllers\HomeController::class, 'cari'])->name('cari');

Auth::routes();
// --------------------------------------------------------------------------Role Admin atau Operator--------------------------------------------------------------------------
Route::group(['middleware' => ['role:admin|operator']], function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard'); 
        
    // Users 
    Route::middleware('auth')->prefix('users')->name('users.')->group(function(){
    
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
        Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');
    });
    // Profile Routes
    Route::prefix('profile')->name('profile.')->middleware('auth')->group(function(){
        Route::get('/', [DashboardController::class, 'getProfile'])->name('detail');
        Route::post('/update', [DashboardController::class, 'updateProfile'])->name('update');
        Route::post('/change-password', [DashboardController::class, 'changePassword'])->name('change-password');
    });
    // Roles
    Route::resource('roles', App\Http\Controllers\RolesController::class);
    // Operator
    Route::resource('operator', App\Http\Controllers\OperatorController::class);
    Route::get('/update/status/{user_id}/{status}', [OperatorController::class, 'updateStatus'])->name('sts');
    // Barang
    Route::resource('barang', App\Http\Controllers\BarangController::class);
});


// --------------------------------------------------------------------------Role Peminjam--------------------------------------------------------------------------

Route::group(['middleware' => ['role:peminjam']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/checkout', [App\Http\Controllers\HomeController::class, 'create'])->name('create');
});




    

