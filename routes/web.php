<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;

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

// Login
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/', [AuthController::class, 'login']);

//Logout
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'userAkses:admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'adminIndex'])->name('admin.index');

    Route::resource('/admin/pengguna', UserController::class);
});

Route::middleware(['auth', 'userAkses:kantin'])->group(function () {
    Route::get('/kantin', [DashboardController::class, 'kantinIndex'])->name('kantin.index');

    Route::resource('/kantin/produk', ProdukController::class);
    Route::resource('/kantin/kategori', KategoriController::class);
});

Route::middleware(['auth', 'userAkses:bank'])->group(function () {
    Route::get('/bank', [DashboardController::class, 'bankIndex'])->name('bank.index');

    // Top Up
    Route::get('/bank/topup', [BankController::class, 'bankTopupIndex'])->name('bank.topup');
    Route::put('/bank/konfirmasiTopup/{id}', [BankController::class, 'konfirmasiTopup'])->name('konfirmasi.topup');
    Route::put('/bank/tolakTopup/{id}', [BankController::class, 'tolakTopup'])->name('tolak.topup');

    // Tarik Tunai
    Route::get('/bank/withdrawal', [BankController::class, 'bankWithdrawalIndex'])->name('bank.withdrawal');
    Route::put('/bank/konfirmasiWithdrawal/{id}', [BankController::class, 'konfirmasiWithdrawal'])->name('konfirmasi.withdrawal');
    Route::put('/bank/tolakWithdrawal/{id}', [BankController::class, 'tolakWithdrawal'])->name('tolak.withdrawal');
});

Route::middleware(['auth', 'userAkses:customer'])->group(function () {
    Route::get('/customer', [DashboardController::class, 'customerIndex'])->name('customer.index');

    // Route::get('/customer/topup', [BankController::class, 'topupIndex'])->name('topup.index');

    Route::post('/customer/topup', [BankController::class, 'topup'])->name('topup.request');
    Route::post('/customer/withdrawal', [BankController::class, 'withdrawal'])->name('withdrawal.request');

    Route::get('/customer/kantin', [TransaksiController::class, 'customerKantinIndex'])->name('customer.kantin');
    Route::post('/customer/tambahKeKeranjang/{id}', [TransaksiController::class, 'addToCart'])->name('addToCart');
    Route::get('/customer/keranjang', [TransaksiController::class, 'keranjangIndex'])->name('customer.keranjang');
    Route::post('/customer/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
    Route::delete('/customer/keranjang/destroy/{id}', [TransaksiController::class, 'keranjangDestroy'])->name('keranjang.destroy');
});
