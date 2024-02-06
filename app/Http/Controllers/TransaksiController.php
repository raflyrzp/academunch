<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Wallet;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function siswaKantinIndex()
    {
        $title = 'Kantin';
        $produks = Produk::all();
        $bestSeller = Produk::select('produks.*', DB::raw('SUM(transaksis.kuantitas) as total_terjual'))
            ->join('transaksis', 'produks.id', '=', 'transaksis.id_produk')
            ->groupBy('produks.id')
            ->orderByDesc('total_terjual')
            ->first();

        return view('siswa.kantin', compact('title', 'produks', 'bestSeller'));
    }

    public function keranjangIndex()
    {
        $title = 'Keranjang';
        $id_user = Auth::id();
        $keranjangs = Keranjang::where('id_user', $id_user)->get();
        $wallet = Wallet::where('id_user', auth()->id())->first();

        $totalHarga = $keranjangs->sum('total_harga');

        // foreach ($keranjangs as $keranjang) {
        //     $totalHargaPerItem = $keranjang->produk->harga * $keranjang->jumlah_produk;
        //     $totalHarga += $totalHargaPerItem;
        // }

        return view('siswa.keranjang', compact('title', 'keranjangs', 'totalHarga', 'wallet'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'jumlah_produk' => 'required|numeric',
            'id_produk' => 'required',
            'id_user' => 'required',
            'harga' => 'required'
        ]);

        $id_user = $request->id_user;
        $produk = Produk::find($request->id_produk);

        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $jumlah_produk = $request->jumlah_produk;
        $total_harga = $request->harga * $jumlah_produk;

        $produk_sama = Keranjang::where('id_user', $id_user)->where('id_produk', $produk->id)->first();

        if ($produk_sama) {
            $produk_sama->jumlah_produk += $jumlah_produk;
            $produk_sama->total_harga += $total_harga;
            $produk_sama->save();
        } else {
            Keranjang::create([
                'id_user' => $id_user,
                'id_produk' => $produk->id,
                'jumlah_produk' => $jumlah_produk,
                'total_harga' => $total_harga,
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil menambah produk ke keranjang');
    }

    public function keranjangDestroy($id)
    {
        $keranjang = Keranjang::findOrFail($id);

        if (!$keranjang) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $keranjang->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus produk dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $id_user = auth()->user()->id;

        $selectedProducts = Keranjang::where('id_user', $id_user)
            ->get();

        $totalHarga = $selectedProducts->sum('total_harga');
        $userWallet = Wallet::where('id_user', $id_user)->first();

        if ($userWallet->saldo < $totalHarga) {
            return redirect()->route('siswa.index')->with(['error' => 'Saldo anda tidak mencukupi.']);
        }
        $invoice = 'INV' . auth()->user()->id . now()->format('dmYHis');
        session(['current_invoice' => $invoice]);

        foreach ($selectedProducts as $selectedProduct) {
            $transaksi = new Transaksi();
            $transaksi->id_user = $id_user;
            $transaksi->id_produk = $selectedProduct->id_produk;
            $transaksi->harga = $selectedProduct->produk->harga;
            $transaksi->total_harga = $selectedProduct->total_harga;
            $transaksi->kuantitas = $selectedProduct->jumlah_produk;
            $transaksi->invoice = $invoice;
            $transaksi->save();

            $produk = Produk::find($selectedProduct->id_produk);
            $produk->stok -= $selectedProduct->jumlah_produk;
            $produk->save();

            $selectedProduct->delete();
        }

        $userWallet->saldo -= $totalHarga;
        $userWallet->save();
        $pembeli = auth()->user()->nama;
        $email = auth()->user()->email;

        $title = 'Invoice';
        return view('invoice.invoice', compact('selectedProducts', 'totalHarga', 'title', 'invoice', 'pembeli', 'email'));
    }

    public function konfirmasiTransaksi($invoice)
    {
        $transaksis = Transaksi::where('invoice', $invoice)->get();

        foreach ($transaksis as $transaksi) {
            $transaksi->status = 'dikonfirmasi';
            $transaksi->save();
        }

        return redirect()->back()->with('success', 'Transaksi dikonfirmasi');
    }

    public function tolakTransaksi($invoice)
    {
        $transaksis = Transaksi::where('invoice', $invoice)->get();

        foreach ($transaksis as $transaksi) {
            $produks = Produk::where('id', $transaksi->id_produk)->get();
            foreach ($produks as $produk) {
                $produk->stok += $transaksi->kuantitas;
                $produk->save();
            }

            $transaksi->status = 'ditolak';
            $transaksi->save();
        }
        $totalHarga = $transaksis->sum('total_harga');

        $wallet = Wallet::where('id_user', $transaksi->id_user)->first();
        $wallet->saldo += $totalHarga;
        $wallet->save();

        return redirect()->back()->with('success', 'Transaksi ditolak');
    }

    public function batalTransaksi($invoice)
    {
        $transaksis = Transaksi::where('invoice', $invoice)->get();

        foreach ($transaksis as $transaksi) {
            if ($transaksi->status === 'dikonfirmasi') {
                return redirect()->back()->with('error', 'Transaksi sudah dikonfirmasi.');
            } else {
                $produks = Produk::where('id', $transaksi->id_produk)->get();
                foreach ($produks as $produk) {
                    $produk->stok += $transaksi->kuantitas;
                    $produk->save();
                }

                $transaksi->status = 'batal';
                $transaksi->save();
            }
        }
        $totalHarga = $transaksis->sum('total_harga');

        $wallet = Wallet::where('id_user', $transaksi->id_user)->first();
        $wallet->saldo += $totalHarga;
        $wallet->save();

        return redirect()->back()->with('success', 'Transaksi dibatalkan');
    }


    public function laporanTransaksi()
    {
        $title = 'Laporan Transaksi';

        $transaksis = Transaksi::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(total_harga) as total_harga'))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalHargaPerHari = Transaksi::whereIn('status', ['dipesan', 'dikonfirmasi'])->sum('total_harga');

        $totalHarga = $transaksis->sum('total_harga');

        return view('kantin.laporan.transaksi', compact('transaksis', 'totalHarga', 'title', 'totalHargaPerHari'));
    }

    public function riwayatTransaksi()
    {
        $title = 'Riwayat Transaksi';
        $transaksis = Transaksi::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(total_harga) as total_harga'))
            ->where('id_user', auth()->id())
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('siswa.riwayat.transaksi', compact('transaksis', 'title'));
    }

    public function detailRiwayatTransaksi($invoice)
    {
        $title = 'Detail Pembelian';

        $selectedProducts = Transaksi::where('invoice', $invoice)->get();
        $totalHarga = $selectedProducts->sum('total_harga');
        $pembeli = $selectedProducts->first()->user->nama;
        $email = $selectedProducts->first()->user->email;
        session(['current_invoice' => $invoice]);

        return view('invoice.invoice', compact('selectedProducts', 'totalHarga', 'invoice', 'title', 'pembeli', 'email'));
    }

    public function cetakTransaksi()
    {
        $invoice = session('current_invoice');
        $transaksis = Transaksi::where('invoice', $invoice)->get();
        $totalHarga = $transaksis->sum('total_harga');
        $status = $transaksis->first()->status;
        $pembeli = $transaksis->first()->user->nama;

        $selectedProducts = [];
        foreach ($transaksis as $transaksi) {
            $produk = Produk::withTrashed()->find($transaksi->id_produk);

            $selectedProducts[] = [
                'produk' => $produk,
                'nama_produk' => $produk->nama_produk,
                'kuantitas' => $transaksi->kuantitas,
                'total_harga' => $transaksi->total_harga,
            ];
        }

        session()->forget('current_invoice');

        return view('invoice.cetak-invoice', compact('selectedProducts', 'totalHarga', 'invoice', 'status', 'pembeli'));
    }
}
