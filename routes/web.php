<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

/*
|--------------------------------------------------------------------------
| Authentication Routes (Guest)
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::get('/regist', [AuthController::class, 'regist'])->name('regist');
Route::post('/regist', [AuthController::class, 'store']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Invoice & Print Routes
|--------------------------------------------------------------------------
*/
Route::get('/transaksi/cetak', [TransaksiController::class, 'cetakTransaksi'])->name('cetak.transaksi');
Route::get('/riwayat/transaksi/{invoice}', [TransaksiController::class, 'detailRiwayatTransaksi'])->name('transaksi.detail');
Route::get('/riwayat/cetak-seluruh-topup', [BankController::class, 'cetakSeluruhTopup'])->name('cetak.seluruh.topup');
Route::get('/riwayat/cetak-withdrawal', [BankController::class, 'cetakSeluruhWithdrawal'])->name('cetak.seluruh.withdrawal');
Route::get('/riwayat/cetak-topup/{kode_unik}', [BankController::class, 'cetakTopup'])->name('cetak.topup');
Route::get('/riwayat/cetak-withdrawal/{kode_unik}', [BankController::class, 'cetakWithdrawal'])->name('cetak.withdrawal');

/*
|--------------------------------------------------------------------------
| Banking Operations Routes
|--------------------------------------------------------------------------
*/
Route::post('/withdrawal', [BankController::class, 'withdrawal'])->name('withdrawal.request');
Route::post('/topup', [BankController::class, 'topup'])->name('topup.request');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'userAkses:admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'adminIndex'])->name('admin.index');
    Route::resource('/admin/pengguna', UserController::class)->only(['index', 'store', 'update', 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Kantin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'userAkses:kantin'])->group(function () {
    Route::get('/kantin', [DashboardController::class, 'kantinIndex'])->name('kantin.index');

    // Produk Resource
    Route::resource('/kantin/produk', ProdukController::class)->only(['index', 'store', 'update', 'destroy']);

    // Kategori Resource
    Route::resource('/kantin/kategori', KategoriController::class)->only(['index', 'store', 'update', 'destroy']);

    // Transaksi Management
    Route::put('/kantin/konfirmasiTransaksi/{id}', [TransaksiController::class, 'konfirmasiTransaksi'])->name('konfirmasi.transaksi');
    Route::put('/kantin/tolakTransaksi/{id}', [TransaksiController::class, 'tolakTransaksi'])->name('tolak.transaksi');

    // Laporan
    Route::get('/kantin/riwayat/transaksi', [TransaksiController::class, 'laporanTransaksi'])->name('kantin.laporan');
});

/*
|--------------------------------------------------------------------------
| Bank Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'userAkses:bank'])->group(function () {
    Route::get('/bank', [DashboardController::class, 'bankIndex'])->name('bank.index');

    // Top Up Management
    Route::get('/bank/topup', [BankController::class, 'bankTopupIndex'])->name('bank.topup');
    Route::put('/bank/konfirmasiTopup/{id}', [BankController::class, 'konfirmasiTopup'])->name('konfirmasi.topup');
    Route::put('/bank/tolakTopup/{id}', [BankController::class, 'tolakTopup'])->name('tolak.topup');

    // Withdrawal Management
    Route::get('/bank/withdrawal', [BankController::class, 'bankWithdrawalIndex'])->name('bank.withdrawal');
    Route::put('/bank/konfirmasiWithdrawal/{id}', [BankController::class, 'konfirmasiWithdrawal'])->name('konfirmasi.withdrawal');
    Route::put('/bank/tolakWithdrawal/{id}', [BankController::class, 'tolakWithdrawal'])->name('tolak.withdrawal');

    // Laporan
    Route::get('/bank/laporan/topup', [BankController::class, 'laporanTopup'])->name('bank.laporan.topup');
    Route::get('/bank/laporan/withdrawal', [BankController::class, 'laporanWithdrawal'])->name('bank.laporan.withdrawal');
});

/*
|--------------------------------------------------------------------------
| Siswa Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'userAkses:siswa'])->group(function () {
    Route::get('/siswa', [DashboardController::class, 'siswaIndex'])->name('siswa.index');

    // Transaksi
    Route::get('/siswa/kantin', [TransaksiController::class, 'siswaKantinIndex'])->name('siswa.kantin');
    Route::post('/siswa/tambahKeKeranjang/{id}', [TransaksiController::class, 'addToCart'])->name('addToCart');
    Route::get('/siswa/keranjang', [TransaksiController::class, 'keranjangIndex'])->name('siswa.keranjang');
    Route::post('/siswa/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
    Route::delete('/siswa/keranjang/destroy/{id}', [TransaksiController::class, 'keranjangDestroy'])->name('keranjang.destroy');
    Route::put('/siswa/batalTransaksi/{invoice}', [TransaksiController::class, 'batalTransaksi'])->name('batal.transaksi');

    // Riwayat
    Route::get('/siswa/riwayat/transaksi', [TransaksiController::class, 'riwayatTransaksi'])->name('siswa.riwayat.transaksi');
    Route::get('/siswa/riwayat/topup', [BankController::class, 'riwayatTopup'])->name('siswa.riwayat.topup');
    Route::get('/siswa/riwayat/withdrawal', [BankController::class, 'riwayatWithdrawal'])->name('siswa.riwayat.withdrawal');
});
