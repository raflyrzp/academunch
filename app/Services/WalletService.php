<?php

namespace App\Services;

use App\Models\Wallet;
use App\Traits\GeneratesUniqueCode;

class WalletService
{
    use GeneratesUniqueCode;

    /**
     * Buat wallet baru untuk user
     *
     * @param int $userId
     * @return Wallet
     */
    public function createWallet(int $userId): Wallet
    {
        return Wallet::create([
            'rekening' => $this->generateAccountNumber($userId),
            'id_user' => $userId,
            'saldo' => 0,
            'status' => 'aktif'
        ]);
    }

    /**
     * Tambah saldo wallet
     *
     * @param Wallet $wallet
     * @param int $amount
     * @return Wallet
     */
    public function addBalance(Wallet $wallet, int $amount): Wallet
    {
        $wallet->saldo += $amount;
        $wallet->save();

        return $wallet;
    }

    /**
     * Kurangi saldo wallet
     *
     * @param Wallet $wallet
     * @param int $amount
     * @return Wallet
     */
    public function deductBalance(Wallet $wallet, int $amount): Wallet
    {
        $wallet->saldo -= $amount;
        $wallet->save();

        return $wallet;
    }

    /**
     * Cek apakah saldo mencukupi
     *
     * @param Wallet $wallet
     * @param int $amount
     * @return bool
     */
    public function hasSufficientBalance(Wallet $wallet, int $amount): bool
    {
        return $wallet->saldo >= $amount;
    }

    /**
     * Dapatkan wallet berdasarkan rekening
     *
     * @param string $rekening
     * @return Wallet|null
     */
    public function findByRekening(string $rekening): ?Wallet
    {
        return Wallet::where('rekening', $rekening)->first();
    }

    /**
     * Dapatkan wallet berdasarkan user ID
     *
     * @param int $userId
     * @return Wallet|null
     */
    public function findByUserId(int $userId): ?Wallet
    {
        return Wallet::where('id_user', $userId)->first();
    }
}
