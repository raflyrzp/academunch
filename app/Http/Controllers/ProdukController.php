<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\Kategori;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kantin.produk', [
            'title' => 'Data Produk',
            'produks' => Produk::with('kategori')->get(),
            'kategoris' => Kategori::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdukRequest $request)
    {
        // Cek apakah produk dengan nama yang sama sudah dihapus (soft delete)
        $produkLama = Produk::onlyTrashed()
            ->where('nama_produk', $request->nama_produk)
            ->first();

        if ($produkLama) {
            return $this->restoreProduct($produkLama, $request);
        }

        // Cek apakah produk dengan nama yang sama sudah ada (update stok)
        $existingProduk = Produk::where('nama_produk', $request->nama_produk)->first();

        if ($existingProduk) {
            $existingProduk->increment('stok', $request->stok);

            return redirect()->back()->with('success', 'Stok produk berhasil ditambahkan.');
        }

        // Buat produk baru
        $foto = $request->file('foto');
        $foto->storeAs('public/produk', $foto->hashName());

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto' => $foto->hashName(),
            'desc' => $request->desc,
            'id_kategori' => $request->id_kategori,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan sebuah data produk baru.');
    }

    /**
     * Restore produk yang sudah dihapus
     */
    protected function restoreProduct(Produk $produk, StoreProdukRequest $request): \Illuminate\Http\RedirectResponse
    {
        $foto = $request->file('foto');
        $foto->storeAs('public/produk', $foto->hashName());

        $produk->restore();
        $produk->update([
            'harga' => $request->harga,
            'stok' => $request->stok,
            'desc' => $request->desc,
            'id_kategori' => $request->id_kategori,
            'foto' => $foto->hashName(),
        ]);

        return redirect()->back()->with('success', 'Produk berhasil dikembalikan dan diperbarui.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdukRequest $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $data = [
            'nama_produk' => $request->nama_produk,
            'id_kategori' => $request->id_kategori,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'desc' => $request->desc,
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika bukan default
            if ($produk->foto !== 'default.jpeg') {
                Storage::delete('public/produk/' . $produk->foto);
            }

            $foto = $request->file('foto');
            $foto->storeAs('public/produk', $foto->hashName());
            $data['foto'] = $foto->hashName();
        }

        $produk->update($data);

        return redirect()->back()->with('success', 'Berhasil mengedit sebuah data produk.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus semua item keranjang yang mengandung produk ini
        Keranjang::where('id_produk', $id)->delete();

        // Hapus foto produk
        if ($produk->foto !== 'default.jpeg') {
            Storage::delete('public/produk/' . $produk->foto);
        }

        $produk->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus sebuah data produk.');
    }
}
