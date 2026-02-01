<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Services\TransaksiService;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    protected TransaksiService $transaksiService;
    protected WalletService $walletService;

    public function __construct(TransaksiService $transaksiService, WalletService $walletService)
    {
        $this->transaksiService = $transaksiService;
        $this->walletService = $walletService;
    }

    /**
     * Tampilkan halaman kantin untuk siswa
     */
    public function siswaKantinIndex()
    {
        return view('siswa.kantin', [
            'title' => 'Kantin',
            'produks' => Produk::all(),
            'bestSeller' => $this->transaksiService->getBestSeller(),
        ]);
    }

    /**
     * Tampilkan halaman keranjang
     */
    public function keranjangIndex()
    {
        $userId = auth()->id();
        $keranjangs = Keranjang::where('id_user', $userId)->with('produk')->get();
        
        return view('siswa.keranjang', [
            'title' => 'Keranjang',
            'keranjangs' => $keranjangs,
            'totalHarga' => $keranjangs->sum('total_harga'),
            'wallet' => $this->walletService->findByUserId($userId),
        ]);
    }

    /**
     * Tambah produk ke keranjang
     */
    public function addToCart(AddToCartRequest $request)
    {
        $produk = Produk::find($request->id_produk);

        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $totalHarga = $request->harga * $request->jumlah_produk;

        $existingItem = Keranjang::where('id_user', $request->id_user)
            ->where('id_produk', $produk->id)
            ->first();

        if ($existingItem) {
            $existingItem->increment('jumlah_produk', $request->jumlah_produk);
            $existingItem->increment('total_harga', $totalHarga);
        } else {
            Keranjang::create([
                'id_user' => $request->id_user,
                'id_produk' => $produk->id,
                'jumlah_produk' => $request->jumlah_produk,
                'total_harga' => $totalHarga,
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil menambah produk ke keranjang');
    }

    /**
     * Hapus item dari keranjang
     */
    public function keranjangDestroy($id)
    {
        $keranjang = Keranjang::findOrFail($id);
        $keranjang->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus produk dari keranjang.');
    }

    /**
     * Proses checkout
     */
    public function checkout()
    {
        try {
            $result = $this->transaksiService->processCheckout(auth()->id());
            
            session(['current_invoice' => $result['invoice']]);

            return view('invoice.invoice', [
                'title' => 'Invoice',
                'invoice' => $result['invoice'],
                'totalHarga' => $result['total_harga'],
                'selectedProducts' => $result['products'],
                'pembeli' => auth()->user()->nama,
                'email' => auth()->user()->email,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('siswa.index')->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Konfirmasi transaksi oleh kantin
     */
    public function konfirmasiTransaksi($invoice)
    {
        $this->transaksiService->confirmTransaction($invoice);

        return redirect()->back()->with('success', 'Transaksi dikonfirmasi');
    }

    /**
     * Tolak transaksi oleh kantin
     */
    public function tolakTransaksi($invoice)
    {
        $this->transaksiService->rejectTransaction($invoice);

        return redirect()->back()->with('success', 'Transaksi ditolak');
    }

    /**
     * Batalkan transaksi oleh siswa
     */
    public function batalTransaksi($invoice)
    {
        try {
            $this->transaksiService->cancelTransaction($invoice);

            return redirect()->back()->with('success', 'Transaksi dibatalkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Laporan transaksi kantin
     */
    public function laporanTransaksi()
    {
        $transaksis = $this->transaksiService->getDailyReport();
        $totalHargaPerHari = Transaksi::whereIn('status', ['dipesan', 'dikonfirmasi'])
            ->sum('total_harga');

        return view('kantin.laporan.transaksi', [
            'title' => 'Laporan Transaksi',
            'transaksis' => $transaksis,
            'totalHarga' => $transaksis->sum('total_harga'),
            'totalHargaPerHari' => $totalHargaPerHari,
        ]);
    }

    /**
     * Riwayat transaksi siswa
     */
    public function riwayatTransaksi()
    {
        return view('siswa.riwayat.transaksi', [
            'title' => 'Riwayat Transaksi',
            'transaksis' => $this->transaksiService->getDailyReport(auth()->id()),
        ]);
    }

    /**
     * Detail riwayat transaksi
     */
    public function detailRiwayatTransaksi($invoice)
    {
        $selectedProducts = Transaksi::where('invoice', $invoice)->with('produk', 'user')->get();
        
        if ($selectedProducts->isEmpty()) {
            abort(404);
        }

        session(['current_invoice' => $invoice]);

        return view('invoice.invoice', [
            'title' => 'Detail Pembelian',
            'invoice' => $invoice,
            'totalHarga' => $selectedProducts->sum('total_harga'),
            'selectedProducts' => $selectedProducts,
            'pembeli' => $selectedProducts->first()->user->nama,
            'email' => $selectedProducts->first()->user->email,
        ]);
    }

    /**
     * Cetak transaksi
     */
    public function cetakTransaksi()
    {
        $invoice = session('current_invoice');
        
        if (!$invoice) {
            return redirect()->route('siswa.riwayat.transaksi')->with('error', 'Invoice tidak ditemukan');
        }

        $transaksis = Transaksi::where('invoice', $invoice)->with('user')->get();
        
        if ($transaksis->isEmpty()) {
            return redirect()->route('siswa.riwayat.transaksi')->with('error', 'Transaksi tidak ditemukan');
        }

        $selectedProducts = $transaksis->map(function ($transaksi) {
            $produk = Produk::withTrashed()->find($transaksi->id_produk);
            
            return [
                'produk' => $produk,
                'nama_produk' => $produk->nama_produk,
                'kuantitas' => $transaksi->kuantitas,
                'total_harga' => $transaksi->total_harga,
            ];
        })->toArray();

        session()->forget('current_invoice');

        return view('invoice.cetak-invoice', [
            'selectedProducts' => $selectedProducts,
            'totalHarga' => $transaksis->sum('total_harga'),
            'invoice' => $invoice,
            'status' => $transaksis->first()->status,
            'pembeli' => $transaksis->first()->user->nama,
            'tanggal' => $transaksis->first()->created_at,
        ]);
    }
}
