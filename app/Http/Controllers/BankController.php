<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopupRequest;
use App\Http\Requests\WithdrawalRequest;
use App\Models\TopUp;
use App\Models\Withdrawal;
use App\Services\BankingService;
use App\Services\WalletService;

class BankController extends Controller
{
    protected BankingService $bankingService;
    protected WalletService $walletService;

    public function __construct(BankingService $bankingService, WalletService $walletService)
    {
        $this->bankingService = $bankingService;
        $this->walletService = $walletService;
    }

    /**
     * Index siswa topup
     */
    public function topupIndex()
    {
        return view('siswa.topup', [
            'wallets' => \App\Models\Wallet::all(),
        ]);
    }

    /**
     * Index bank topup
     */
    public function bankTopupIndex()
    {
        return view('bank.topup', [
            'title' => 'Top Up',
            'topups' => TopUp::all(),
        ]);
    }

    /**
     * Index bank withdrawal
     */
    public function bankWithdrawalIndex()
    {
        return view('bank.withdrawal', [
            'title' => 'Tarik Tunai',
            'withdrawals' => Withdrawal::all(),
        ]);
    }

    /**
     * Proses topup
     */
    public function topup(TopupRequest $request)
    {
        try {
            $isBank = auth()->user()->role === 'bank';
            
            $this->bankingService->processTopup(
                $request->rekening,
                $request->nominal,
                $isBank
            );

            return redirect()->back()->with('success', 'Permintaan Top Up berhasil');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Konfirmasi topup
     */
    public function konfirmasiTopup($id)
    {
        $this->bankingService->confirmTopup($id);

        return redirect()->route('bank.index')->with('success', 'Top Up dikonfirmasi');
    }

    /**
     * Tolak topup
     */
    public function tolakTopup($id)
    {
        $this->bankingService->rejectTopup($id);

        return redirect()->route('bank.index')->with('error', 'Top Up telah ditolak');
    }

    /**
     * Proses withdrawal
     */
    public function withdrawal(WithdrawalRequest $request)
    {
        try {
            $isBank = auth()->user()->role === 'bank';
            
            $this->bankingService->processWithdrawal(
                $request->rekening,
                $request->nominal,
                $isBank
            );

            return redirect()->back()->with('success', 'Permintaan Withdrawal berhasil');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Konfirmasi withdrawal
     */
    public function konfirmasiWithdrawal($id)
    {
        $this->bankingService->confirmWithdrawal($id);

        return redirect()->route('bank.index')->with('success', 'Withdrawal dikonfirmasi');
    }

    /**
     * Tolak withdrawal
     */
    public function tolakWithdrawal($id)
    {
        $this->bankingService->rejectWithdrawal($id);

        return redirect()->route('bank.index')->with('error', 'Withdrawal ditolak');
    }

    /**
     * Riwayat topup siswa
     */
    public function riwayatTopup()
    {
        $wallet = $this->walletService->findByUserId(auth()->id());
        
        return view('siswa.riwayat.topup', [
            'title' => 'Riwayat Top Up',
            'topups' => $this->bankingService->getTopupReport($wallet->rekening),
            'wallet' => $wallet,
        ]);
    }

    /**
     * Riwayat withdrawal siswa
     */
    public function riwayatWithdrawal()
    {
        $wallet = $this->walletService->findByUserId(auth()->id());
        
        return view('siswa.riwayat.withdrawal', [
            'title' => 'Riwayat Tarik Tunai',
            'withdrawals' => $this->bankingService->getWithdrawalReport($wallet->rekening),
            'wallet' => $wallet,
        ]);
    }

    /**
     * Laporan topup bank
     */
    public function laporanTopup()
    {
        return view('bank.laporan.topup', [
            'title' => 'Laporan Top Up',
            'topups' => $this->bankingService->getTopupReport(),
        ]);
    }

    /**
     * Laporan withdrawal bank
     */
    public function laporanWithdrawal()
    {
        return view('bank.laporan.withdrawal', [
            'title' => 'Laporan Tarik Tunai',
            'withdrawals' => $this->bankingService->getWithdrawalReport(),
        ]);
    }

    /**
     * Cetak topup individual
     */
    public function cetakTopup($kode_unik)
    {
        $topup = TopUp::where('kode_unik', $kode_unik)->firstOrFail();

        return view('invoice.cetak-topup', compact('topup'));
    }

    /**
     * Cetak withdrawal individual
     */
    public function cetakWithdrawal($kode_unik)
    {
        $withdrawal = Withdrawal::where('kode_unik', $kode_unik)->firstOrFail();

        return view('invoice.cetak-withdrawal', compact('withdrawal'));
    }

    /**
     * Cetak seluruh topup
     */
    public function cetakSeluruhTopup()
    {
        $wallet = $this->walletService->findByUserId(auth()->id());
        
        $rekening = auth()->user()->role === 'siswa' ? $wallet->rekening : null;
        $topups = $this->bankingService->getTopupReport($rekening);

        return view('invoice.cetak-seluruh-topup', compact('topups', 'wallet'));
    }

    /**
     * Cetak seluruh withdrawal
     */
    public function cetakSeluruhWithdrawal()
    {
        $wallet = $this->walletService->findByUserId(auth()->id());
        
        $rekening = auth()->user()->role === 'siswa' ? $wallet->rekening : null;
        $withdrawals = $this->bankingService->getWithdrawalReport($rekening);

        return view('invoice.cetak-seluruh-withdrawal', compact('withdrawals', 'wallet'));
    }
}
