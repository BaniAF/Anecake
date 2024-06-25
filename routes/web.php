<?php

use App\Http\Controllers\addProduk;
use App\Http\Controllers\AdminOrder;
use App\Http\Controllers\AdminProduk;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addTransaksi;
use App\Http\Controllers\AdminKategori;
use App\Http\Controllers\LEDController;
use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\AdminTransaksi;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\landingController;
use App\Http\Controllers\OwnerDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// auth
Route::get('/login', [AuthController::class,'render'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('masuk');
Route::post('/logout', [AuthController::class,'logout'])->name('logout');
// end auth

Route::middleware(['check.firebase.auth'])->group(function () {

    // admin
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');

    // admin - produk
    Route::get('/produk', [AdminProduk::class, 'index'])->name('admin.produk');
    Route::get('/produk/tambah-produk', [addProduk::class, 'index'])->name('admin.produk.add');
    Route::post('/produk/tambah-produk', [addProduk::class, 'store'])->name('admin.produk.store');
    Route::post('produk-update/{id}', [AdminProduk::class, 'update'])->name('admin.produk.update');
    Route::post('produk/hapus-produk/{id}', [AdminProduk::class, 'destroy'])->name('admin.produk.destroy');

    // admin  - kategori
    Route::get('/kategori', [AdminKategori::class, 'index'])->name('admin.kategori');
    Route::post('/kategori-update/{id}', [AdminKategori::class, 'update'])->name('admin.kategori.update');
    Route::post('/kategori/tambah-kategori', [AdminKategori::class, 'store'])->name('admin.kategori.store');
    Route::post('/kategori/hapus-kategori/{id}', [AdminKategori::class, 'destroy'])->name('admin.kategori.hapus');

    // admin - transaksi
    Route::get('/transaksi', [AdminTransaksi::class, 'index'])->name('admin.transaksi');
    Route::get('/transaksi/tambah-transaksi', [addTransaksi::class, 'index'])->name('admin.transaksi.add');

    // admin - order
    Route::get('/order', [AdminOrder::class, 'index'])->name('admin.order');

    // owner
    Route::get('/home', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');
});

// landing page
Route::get('/', [landingController::class, 'index']);

Route::get('/led-control', [LEDController::class, 'index']);
Route::get('/led-status', [LEDController::class, 'status']);
Route::get('/led-status', [LEDController::class, 'ledstatus']);
Route::post('/led-control', [LEDController::class, 'control']);