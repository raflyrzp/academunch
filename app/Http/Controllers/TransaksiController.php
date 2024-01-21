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
    public function customerKantinIndex()
    {
        $title = 'Kantin';
        $produks = Produk::all();
        $bestSeller = Produk::select('produks.*', DB::raw('SUM(transaksis.kuantitas) as total_terjual'))
            ->join('transaksis', 'produks.id', '=', 'transaksis.id_produk')
            ->groupBy('produks.id')
            ->orderByDesc('total_terjual')
            ->first();

        return view('customer.kantin', compact('title', 'produks', 'bestSeller'));
    }

    public function keranjangIndex()
    {
        $title = 'Keranjang';
        $id_user = Auth::id();
        $keranjangs = Keranjang::where('id_user', $id_user)->get();

        $totalHarga = 0;

        foreach ($keranjangs as $keranjang) {
            $totalHargaPerItem = $keranjang->produk->harga * $keranjang->jumlah_produk;
            $totalHarga += $totalHargaPerItem;
        }

        return view('customer.keranjang', compact('title', 'keranjangs', 'totalHarga'));
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
            return redirect()->route('customer.index')->with(['error' => 'Saldo anda tidak mencukupi.']);
        }
        $invoice = 'INV' . auth()->user()->id . now()->format('dmYHis');

        foreach ($selectedProducts as $product) {
            $transaksi = new Transaksi();
            $transaksi->id_user = $id_user;
            $transaksi->id_produk = $product->id_produk;
            $transaksi->harga = $product->produk->harga;
            $transaksi->total_harga = $product->total_harga;
            $transaksi->kuantitas = $product->jumlah_produk;
            $transaksi->tgl_transaksi = now();
            $transaksi->invoice = $invoice;
            $transaksi->save();

            $produk = Produk::find($product->id_produk);
            $produk->stok -= $product->jumlah_produk;
            $produk->save();

            $product->delete();
        }

        $userWallet->saldo -= $totalHarga;
        $userWallet->save();
        // $transaksis = Transaksi::where('invoice', $invoice)->get();

        $title = 'Invoice';
        return view('customer.invoice', compact('selectedProducts', 'totalHarga', 'title', 'invoice'));

        // return redirect()->route('customer.index')->with(['success' => 'Berhasil melakukan pembelian!']);
    }
}
