<?php

namespace App\Traits;

trait GeneratesUniqueCode
{
    /**
     * Generate unique code dengan prefix tertentu
     *
     * @param string $prefix
     * @return string
     */
    protected function generateUniqueCode(string $prefix): string
    {
        return $prefix . auth()->id() . now()->format('dmYHis');
    }

    /**
     * Generate invoice number
     *
     * @return string
     */
    protected function generateInvoiceNumber(): string
    {
        return $this->generateUniqueCode('INV');
    }

    /**
     * Generate kode topup
     *
     * @return string
     */
    protected function generateTopupCode(): string
    {
        return $this->generateUniqueCode('TU');
    }

    /**
     * Generate kode withdrawal
     *
     * @return string
     */
    protected function generateWithdrawalCode(): string
    {
        return $this->generateUniqueCode('WD');
    }

    /**
     * Generate nomor rekening
     *
     * @param int $userId
     * @return string
     */
    protected function generateAccountNumber(int $userId): string
    {
        return '64' . $userId . now()->format('YmdHis');
    }
}
