<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TopUp;
use App\Models\Produk;
use App\Models\Wallet;
use App\Models\Transaksi;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function adminIndex()
    {
        $title = 'Dashboard';
        $users = User::all();
        return view('admin.index', compact('title', 'users'));
    }

    public function kantinIndex()
    {
        $title = 'Dashboard';
        $produks = Produk::all();
        $pemasukan = Transaksi::all()->sum('total_harga');
        $pemasukanHariIni = Transaksi::whereDate('tgl_transaksi', today())->sum('total_harga');
        return view('kantin.index', compact('title', 'produks', 'pemasukan', 'pemasukanHariIni'));
    }

    public function bankIndex()
    {
        $title = 'Dashboard';
        $customers = User::where('role', 'customer')->get();
        $wallets = Wallet::all();
        $requestTopups = TopUp::where('status', 'menunggu')->get();
        $requestWithdrawals = Withdrawal::where('status', 'menunggu')->get();
        $dataTopup = TopUp::all()->count();
        $dataWithdrawal = Withdrawal::all()->count();
        return view('bank.index', compact('title', 'customers', 'wallets', 'requestTopups', 'requestWithdrawals', 'dataTopup', 'dataWithdrawal'));
    }

    public function customerIndex()
    {
        $title = 'Dashboard';
        $wallet = Wallet::where('id_user', auth()->user()->id)->first();
        $pengeluaran = Transaksi::where('id_user', auth()->id())->sum('total_harga');
        return view('customer.index', compact('title', 'wallet', 'pengeluaran'));
    }
}
