<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Produk;
use App\Models\Wallet;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User Seeder
        $dataUser = [
            [
                'nama' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => bcrypt('admin'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'nama' => 'bank',
                'email' => 'bank@gmail.com',
                'role' => 'bank',
                'password' => bcrypt('bank'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'nama' => 'kantin',
                'email' => 'kantin@gmail.com',
                'role' => 'kantin',
                'password' => bcrypt('kantin'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'nama' => 'siswa',
                'email' => 'siswa@gmail.com',
                'role' => 'siswa',
                'password' => bcrypt('siswa'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
        ];

        foreach ($dataUser as $key => $val) {
            User::create($val);
        }

        // Kategori Seeder
        $dataKategori = [
            [
                'nama_kategori' => 'Tidak ada',
            ],
            [
                'nama_kategori' => 'Makanan',
            ],
            [
                'nama_kategori' => 'Minuman',
            ],
        ];

        foreach ($dataKategori as $key => $val) {
            Kategori::create($val);
        }

        // Produk Seeder
        $dataProduk = [
            [
                'nama_produk' => 'Vit',
                'harga' => 3000,
                'stok' => 10,
                'foto' => 'default.jpeg',
                'desc' => 'minuman air mineral saingan Aqua',
                'id_kategori' => 3,
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

        foreach ($dataProduk as $key => $val) {
            Produk::create($val);
        }

        // Wallet Seeder
        $dataWallet = [
            [
                'rekening' => '641234567890',
                'id_user' => 1,
                'saldo' => 1000000,
                'status' => 'aktif'
            ],
            [
                'rekening' => '640987654321',
                'id_user' => 2,
                'saldo' => 1000000,
                'status' => 'aktif'
            ],
            [
                'rekening' => '641212343456',
                'id_user' => 3,
                'saldo' => 1000000,
                'status' => 'aktif'
            ],
            [
                'rekening' => '640909878765',
                'id_user' => 4,
                'saldo' => 1000000,
                'status' => 'aktif'
            ],
        ];

        foreach ($dataWallet as $key => $val) {
            Wallet::create($val);
        }
    }
}
