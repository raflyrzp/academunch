<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TopUp;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    public function topupIndex()
    {
        $wallets = Wallet::all();
        return view('siswa.topup', compact('wallets'));
    }

    public function bankTopupIndex()
    {
        $title = 'Top Up';
        $topups = TopUp::all();
        return view('bank.topup', compact('topups', 'title'));
    }

    public function bankWithdrawalIndex()
    {
        $title = 'Tarik Tunai';
        $withdrawals = Withdrawal::all();
        return view('bank.withdrawal', compact('withdrawals', 'title'));
    }

    public function topup(Request $request)
    {
        $request->validate([
            'nominal' => 'required|integer',
            'rekening' => 'required|string|exists:wallets,rekening',
        ]);

        $kodeUnik = "TU" . auth()->user()->id . now()->format('dmYHis');
        $topup = TopUp::create([
            'rekening' => $request->rekening,
            'nominal' => $request->nominal,
            'kode_unik' => $kodeUnik,
            'status' => 'menunggu',
        ]);

        return redirect()->route('siswa.index')->with('success', 'Permintaan Top Up berhasil');
    }

    public function konfirmasiTopup($id)
    {
        $topup = TopUp::findOrFail($id);

        $topup->status = 'dikonfirmasi';
        $topup->save();

        $wallet = Wallet::where('rekening', $topup->rekening)->first();
        $wallet->saldo += $topup->nominal;
        $wallet->save();

        return redirect()->route('bank.index')->with('success', 'Top Up dikonfirmasi');
    }

    public function tolakTopup($id)
    {
        $topup = TopUp::findOrFail($id);

        $topup->status = 'ditolak';
        $topup->save();

        return redirect()->route('bank.index')->with('error', 'Top Up telah ditolak');
    }

    public function withdrawal(Request $request)
    {
        $request->validate([
            'nominal' => 'required|integer',
            'rekening' => 'required|string|exists:wallets,rekening',
        ]);

        $wallet = Wallet::where('rekening', $request->rekening)->first();
        if ($wallet->saldo < $request->nominal) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi.');
        }

        $kodeUnik = "WD" . auth()->user()->id . now()->format('dmYHis');
        $withdrawal = Withdrawal::create([
            'rekening' => $request->rekening,
            'nominal' => $request->nominal,
            'kode_unik' => $kodeUnik,
            'status' => 'menunggu',
        ]);



        return redirect()->route('siswa.index')->with('success', 'Permintaan Withdrawal berhasil');
    }

    public function konfirmasiWithdrawal($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        $withdrawal->status = 'dikonfirmasi';
        $withdrawal->save();

        $wallet = Wallet::where('rekening', $withdrawal->rekening)->first();
        $wallet->saldo -= $withdrawal->nominal;
        $wallet->save();

        return redirect()->route('bank.index')->with('success', 'Withdrawal dikonfirmasi');
    }

    public function tolakWithdrawal($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        $withdrawal->status = 'ditolak';
        $withdrawal->save();

        return redirect()->route('bank.index')->with('error', 'Withdrawal ditolak');
    }

    public function riwayatTopup()
    {
        $title = 'Riwayat Top Up';
        $wallet = Wallet::where('id_user', auth()->id())->first();
        $topups = TopUp::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(nominal) as nominal'))
            ->where('rekening', $wallet->rekening)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('siswa.riwayat.topup', compact('topups', 'title', 'wallet'));
    }

    public function riwayatWithdrawal()
    {
        $title = 'Riwayat Tarik Tunai';
        $wallet = Wallet::where('id_user', auth()->id())->first();
        $withdrawals = Withdrawal::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(nominal) as nominal'))
            ->where('rekening', $wallet->rekening)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('siswa.riwayat.withdrawal', compact('withdrawals', 'title', 'wallet'));
    }

    public function laporanTopup()
    {
        $title = 'Laporan Top Up';

        $topups = TopUp::all();

        return view('bank.laporan.topup', compact('topups', 'title'));
    }

    public function laporanWithdrawal()
    {
        $title = 'Laporan Tarik Tunai';

        $withdrawals = Withdrawal::all();

        return view('bank.laporan.withdrawal', compact('withdrawals', 'title'));
    }
}
