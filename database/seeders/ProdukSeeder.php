<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_produk' => 'Vit',
                'harga' => 3000,
                'stok' => 10,
                'foto' => 'default.jpeg',
                'desc' => 'minuman air mineral saingan Aqua',
                'id_kategori' => 1,
            ],
            [
                'nama_produk' => 'Mie Ayam',
                'harga' => 10000,
                'stok' => 10,
                'foto' => 'default.jpeg',
                'desc' => 'mie pake ayam',
                'id_kategori' => 2,
            ],
        ];

        foreach ($data as $key => $val) {
            Produk::create($val);
        }
    }
}
