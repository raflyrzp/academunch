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
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// INVOICE
Route::get('/transaksi/cetak', [TransaksiController::class, 'cetakTransaksi'])->name('cetak.transaksi');
Route::get('/riwayat/transaksi/{invoice}', [TransaksiController::class, 'detailRiwayatTransaksi'])->name('transaksi.detail');
Route::get('/riwayat/cetak-topup', [BankController::class, 'cetakTopup'])->name('cetak.topup');
Route::get('/riwayat/cetak-withdrawal', [BankController::class, 'cetakWithdrawal'])->name('cetak.withdrawal');

// TARIK TUNAI
Route::post('/withdrawal', [BankController::class, 'withdrawal'])->name('withdrawal.request');

// TOP UP
Route::post('/topup', [BankController::class, 'topup'])->name('topup.request');


Route::middleware(['auth', 'userAkses:admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'adminIndex'])->name('admin.index');

    Route::resource('/admin/pengguna', UserController::class);
});

Route::middleware(['auth', 'userAkses:kantin'])->group(function () {
    Route::get('/kantin', [DashboardController::class, 'kantinIndex'])->name('kantin.index');

    // PRODUK
    Route::resource('/kantin/produk', ProdukController::class);

    // KATEGORI
    Route::resource('/kantin/kategori', KategoriController::class);

    // TRANSAKSI
    Route::put('/kantin/konfirmasiTransaksi/{id}', [TransaksiController::class, 'konfirmasiTransaksi'])->name('konfirmasi.transaksi');
    Route::put('/kantin/tolakTransaksi/{id}', [TransaksiController::class, 'tolakTransaksi'])->name('tolak.transaksi');

    //LAPORAN
    Route::get('/kantin/riwayat/transaksi', [TransaksiController::class, 'laporanTransaksi'])->name('kantin.laporan');
    // Route::get('/kantin/laporan-harian/{tanggal}', [TransaksiController::class, 'laporanTransaksi'])->name('kantin.laporan.harian');
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

    // LAPORAN
    Route::get('/bank/laporan/topup', [BankController::class, 'laporanTopup'])->name('bank.laporan.topup');
    Route::get('/bank/laporan/withdrawal', [BankController::class, 'laporanWithdrawal'])->name('bank.laporan.withdrawal');
});

Route::middleware(['auth', 'userAkses:siswa'])->group(function () {
    Route::get('/siswa', [DashboardController::class, 'siswaIndex'])->name('siswa.index');

    // TRANSAKSI
    Route::get('/siswa/kantin', [TransaksiController::class, 'siswaKantinIndex'])->name('siswa.kantin');
    Route::post('/siswa/tambahKeKeranjang/{id}', [TransaksiController::class, 'addToCart'])->name('addToCart');
    Route::get('/siswa/keranjang', [TransaksiController::class, 'keranjangIndex'])->name('siswa.keranjang');
    Route::post('/siswa/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
    Route::delete('/siswa/keranjang/destroy/{id}', [TransaksiController::class, 'keranjangDestroy'])->name('keranjang.destroy');
    Route::put('/siswa/batalTransaksi/{invoice}', [TransaksiController::class, 'batalTransaksi'])->name('batal.transaksi');

    //RIWAYAT
    Route::get('/siswa/riwayat/transaksi', [TransaksiController::class, 'riwayatTransaksi'])->name('siswa.riwayat.transaksi');
    Route::get('/siswa/riwayat/topup', [BankController::class, 'riwayatTopup'])->name('siswa.riwayat.topup');
    Route::get('/siswa/riwayat/withdrawal', [BankController::class, 'riwayatWithdrawal'])->name('siswa.riwayat.withdrawal');
});
