<?php

namespace App\Services;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Keranjang;
use App\Traits\GeneratesUniqueCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class TransaksiService
{
    use GeneratesUniqueCode;

    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Proses checkout dari keranjang
     *
     * @param int $userId
     * @return array
     * @throws \Exception
     */
    public function processCheckout(int $userId): array
    {
        return DB::transaction(function () use ($userId) {
            $selectedProducts = Keranjang::where('id_user', $userId)->get();
            
            if ($selectedProducts->isEmpty()) {
                throw new \Exception('Keranjang kosong');
            }

            $totalHarga = $selectedProducts->sum('total_harga');
            $userWallet = $this->walletService->findByUserId($userId);

            if (!$this->walletService->hasSufficientBalance($userWallet, $totalHarga)) {
                throw new \Exception('Saldo tidak mencukupi');
            }

            $invoice = $this->generateInvoiceNumber();

            foreach ($selectedProducts as $item) {
                // Buat transaksi
                Transaksi::create([
                    'id_user' => $userId,
                    'id_produk' => $item->id_produk,
                    'harga' => $item->produk->harga,
                    'total_harga' => $item->total_harga,
                    'kuantitas' => $item->jumlah_produk,
                    'invoice' => $invoice,
                ]);

                // Update stok produk
                Produk::where('id', $item->id_produk)
                    ->decrement('stok', $item->jumlah_produk);
            }

            // Kurangi saldo
            $this->walletService->deductBalance($userWallet, $totalHarga);

            // Hapus keranjang
            Keranjang::where('id_user', $userId)->delete();

            return [
                'invoice' => $invoice,
                'total_harga' => $totalHarga,
                'products' => $selectedProducts,
            ];
        });
    }

    /**
     * Konfirmasi transaksi
     *
     * @param string $invoice
     * @return void
     */
    public function confirmTransaction(string $invoice): void
    {
        Transaksi::where('invoice', $invoice)->update(['status' => 'dikonfirmasi']);
    }

    /**
     * Tolak transaksi dan kembalikan stok serta saldo
     *
     * @param string $invoice
     * @return void
     */
    public function rejectTransaction(string $invoice): void
    {
        DB::transaction(function () use ($invoice) {
            $transaksis = Transaksi::where('invoice', $invoice)->get();
            
            if ($transaksis->isEmpty()) {
                return;
            }

            // Kembalikan stok produk
            foreach ($transaksis as $transaksi) {
                Produk::where('id', $transaksi->id_produk)
                    ->increment('stok', $transaksi->kuantitas);
            }

            // Update status transaksi
            Transaksi::where('invoice', $invoice)->update(['status' => 'ditolak']);

            // Kembalikan saldo
            $totalHarga = $transaksis->sum('total_harga');
            $wallet = $this->walletService->findByUserId($transaksis->first()->id_user);
            $this->walletService->addBalance($wallet, $totalHarga);
        });
    }

    /**
     * Batalkan transaksi oleh siswa
     *
     * @param string $invoice
     * @return bool
     * @throws \Exception
     */
    public function cancelTransaction(string $invoice): bool
    {
        return DB::transaction(function () use ($invoice) {
            $transaksis = Transaksi::where('invoice', $invoice)->get();

            // Cek apakah sudah dikonfirmasi
            if ($transaksis->contains('status', 'dikonfirmasi')) {
                throw new \Exception('Transaksi sudah dikonfirmasi');
            }

            // Kembalikan stok produk
            foreach ($transaksis as $transaksi) {
                Produk::where('id', $transaksi->id_produk)
                    ->increment('stok', $transaksi->kuantitas);
            }

            // Update status
            Transaksi::where('invoice', $invoice)->update(['status' => 'batal']);

            // Kembalikan saldo
            $totalHarga = $transaksis->sum('total_harga');
            $wallet = $this->walletService->findByUserId($transaksis->first()->id_user);
            $this->walletService->addBalance($wallet, $totalHarga);

            return true;
        });
    }

    /**
     * Dapatkan best seller produk
     *
     * @return Produk|null
     */
    public function getBestSeller(): ?Produk
    {
        return Produk::select('produks.*', DB::raw('SUM(transaksis.kuantitas) as total_terjual'))
            ->join('transaksis', 'produks.id', '=', 'transaksis.id_produk')
            ->groupBy('produks.id')
            ->orderByDesc('total_terjual')
            ->first();
    }

    /**
     * Dapatkan laporan transaksi harian
     *
     * @param int|null $userId
     * @return Collection
     */
    public function getDailyReport(?int $userId = null): Collection
    {
        $query = Transaksi::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('SUM(total_harga) as total_harga')
        );

        if ($userId) {
            $query->where('id_user', $userId);
        }

        return $query->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();
    }
}
