<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TopUp;
use App\Models\Produk;
use App\Models\Wallet;
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
        return view('kantin.index', compact('title', 'produks'));
    }

    public function bankIndex()
    {
        $title = 'Dashboard';
        $customers = User::where('role', 'customer')->get();
        $wallets = Wallet::all();
        $requestTopups = TopUp::where('status', 'menunggu')->get();
        $requestWithdrawals = Withdrawal::where('status', 'menunggu')->get();
        return view('bank.index', compact('title', 'customers', 'wallets', 'requestTopups', 'requestWithdrawals'));
    }

    public function customerIndex()
    {
        $title = 'Dashboard';
        $wallet = Wallet::where('id_user', auth()->user()->id)->first();
        return view('customer.index', compact('title', 'wallet'));
    }
}
