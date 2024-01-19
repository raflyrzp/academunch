<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_kategori' => 'Makanan',
            ],
            [
                'nama_kategori' => 'Minuman',
            ],
        ];

        foreach ($data as $key => $val) {
            Kategori::create($val);
        }
    }
}
