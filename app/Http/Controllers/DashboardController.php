<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\TopUp;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Dashboard admin
     */
    public function adminIndex()
    {
        return view('admin.index', [
            'title' => 'Dashboard',
            'users' => User::all(),
        ]);
    }

    /**
     * Dashboard kantin
     */
    public function kantinIndex()
    {
        $transaksis = Transaksi::select('invoice', DB::raw('SUM(total_harga) as total_harga'))
            ->where('status', 'dipesan')
            ->groupBy('invoice')
            ->orderBy('invoice', 'desc')
            ->get();

        return view('kantin.index', [
            'title' => 'Dashboard',
            'produks' => Produk::all(),
            'pemasukan' => Transaksi::whereIn('status', ['dipesan', 'dikonfirmasi'])->sum('total_harga'),
            'pemasukanHariIni' => Transaksi::whereDate('created_at', today())
                ->whereIn('status', ['dipesan', 'dikonfirmasi'])
                ->sum('total_harga'),
            'transaksis' => $transaksis,
        ]);
    }

    /**
     * Dashboard bank
     */
    public function bankIndex()
    {
        return view('bank.index', [
            'title' => 'Dashboard',
            'siswas' => User::where('role', 'siswa')->get(),
            'wallets' => Wallet::all(),
            'requestTopups' => TopUp::where('status', 'menunggu')->get(),
            'requestWithdrawals' => Withdrawal::where('status', 'menunggu')->get(),
            'dataTopup' => TopUp::count(),
            'dataWithdrawal' => Withdrawal::count(),
        ]);
    }

    /**
     * Dashboard siswa
     */
    public function siswaIndex()
    {
        $userId = auth()->id();

        return view('siswa.index', [
            'title' => 'Dashboard',
            'wallet' => Wallet::where('id_user', $userId)->first(),
            'pengeluaran' => Transaksi::where('id_user', $userId)
                ->whereIn('status', ['dipesan', 'dikonfirmasi'])
                ->sum('total_harga'),
            'transaksis' => Transaksi::where('id_user', $userId)->get(),
        ]);
    }
}
