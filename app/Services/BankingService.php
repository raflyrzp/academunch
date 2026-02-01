<?php

namespace App\Services;

use App\Models\TopUp;
use App\Models\Wallet;
use App\Models\Withdrawal;
use App\Traits\GeneratesUniqueCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class BankingService
{
    use GeneratesUniqueCode;

    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Proses request top up
     *
     * @param string $rekening
     * @param int $nominal
     * @param bool $isBank
     * @return TopUp
     * @throws \Exception
     */
    public function processTopup(string $rekening, int $nominal, bool $isBank = false): TopUp
    {
        return DB::transaction(function () use ($rekening, $nominal, $isBank) {
            $wallet = $this->walletService->findByRekening($rekening);

            if (!$wallet) {
                throw new \Exception('Nomor rekening tidak valid');
            }

            $status = $isBank ? 'dikonfirmasi' : 'menunggu';

            if ($isBank) {
                $this->walletService->addBalance($wallet, $nominal);
            }

            return TopUp::create([
                'rekening' => $rekening,
                'nominal' => $nominal,
                'kode_unik' => $this->generateTopupCode(),
                'status' => $status,
            ]);
        });
    }

    /**
     * Konfirmasi top up
     *
     * @param int $id
     * @return TopUp
     */
    public function confirmTopup(int $id): TopUp
    {
        return DB::transaction(function () use ($id) {
            $topup = TopUp::findOrFail($id);
            $topup->status = 'dikonfirmasi';
            $topup->save();

            $wallet = $this->walletService->findByRekening($topup->rekening);
            $this->walletService->addBalance($wallet, $topup->nominal);

            return $topup;
        });
    }

    /**
     * Tolak top up
     *
     * @param int $id
     * @return TopUp
     */
    public function rejectTopup(int $id): TopUp
    {
        $topup = TopUp::findOrFail($id);
        $topup->status = 'ditolak';
        $topup->save();

        return $topup;
    }

    /**
     * Proses request withdrawal
     *
     * @param string $rekening
     * @param int $nominal
     * @param bool $isBank
     * @return Withdrawal
     * @throws \Exception
     */
    public function processWithdrawal(string $rekening, int $nominal, bool $isBank = false): Withdrawal
    {
        return DB::transaction(function () use ($rekening, $nominal, $isBank) {
            $wallet = $this->walletService->findByRekening($rekening);

            if (!$wallet) {
                throw new \Exception('Nomor rekening tidak valid');
            }

            if (!$this->walletService->hasSufficientBalance($wallet, $nominal)) {
                throw new \Exception('Saldo tidak mencukupi');
            }

            $status = $isBank ? 'dikonfirmasi' : 'menunggu';

            if ($isBank) {
                $this->walletService->deductBalance($wallet, $nominal);
            }

            return Withdrawal::create([
                'rekening' => $rekening,
                'nominal' => $nominal,
                'kode_unik' => $this->generateWithdrawalCode(),
                'status' => $status,
            ]);
        });
    }

    /**
     * Konfirmasi withdrawal
     *
     * @param int $id
     * @return Withdrawal
     */
    public function confirmWithdrawal(int $id): Withdrawal
    {
        return DB::transaction(function () use ($id) {
            $withdrawal = Withdrawal::findOrFail($id);
            $withdrawal->status = 'dikonfirmasi';
            $withdrawal->save();

            $wallet = $this->walletService->findByRekening($withdrawal->rekening);
            $this->walletService->deductBalance($wallet, $withdrawal->nominal);

            return $withdrawal;
        });
    }

    /**
     * Tolak withdrawal
     *
     * @param int $id
     * @return Withdrawal
     */
    public function rejectWithdrawal(int $id): Withdrawal
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $withdrawal->status = 'ditolak';
        $withdrawal->save();

        return $withdrawal;
    }

    /**
     * Dapatkan laporan topup harian
     *
     * @param string|null $rekening
     * @return Collection
     */
    public function getTopupReport(?string $rekening = null): Collection
    {
        $query = TopUp::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('SUM(nominal) as nominal')
        );

        if ($rekening) {
            $query->where('rekening', $rekening);
        }

        return $query->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    /**
     * Dapatkan laporan withdrawal harian
     *
     * @param string|null $rekening
     * @return Collection
     */
    public function getWithdrawalReport(?string $rekening = null): Collection
    {
        $query = Withdrawal::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('SUM(nominal) as nominal')
        );

        if ($rekening) {
            $query->where('rekening', $rekening);
        }

        return $query->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();
    }
}
