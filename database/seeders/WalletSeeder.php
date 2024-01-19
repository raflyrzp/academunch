<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            [
                'rekening' => '641234567890',
                'id_user' => 1,
                'saldo' => 100000,
                'status' => 'aktif'
            ],
            [
                'rekening' => '640987654321',
                'id_user' => 2,
                'saldo' => 100000,
                'status' => 'aktif'
            ],
            [
                'rekening' => '641212343456',
                'id_user' => 3,
                'saldo' => 100000,
                'status' => 'aktif'
            ],
            [
                'rekening' => '640909878765',
                'id_user' => 4,
                'saldo' => 100000,
                'status' => 'aktif'
            ],
        ];

        foreach ($data as $key => $val) {
            Wallet::create($val);
        }
    }
}
