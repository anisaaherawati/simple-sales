<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'nama_user' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'no_telp' => '081234567890',
                'alamat' => 'Denpasar',
                'status_user' => 'aktif',
            ]
        );

        User::updateOrCreate(
            ['username' => 'direktur'],
            [
                'nama_user' => 'Direktur',
                'password' => Hash::make('direktur123'),
                'role' => 'direktur',
                'no_telp' => '081234567891',
                'alamat' => 'Denpasar',
                'status_user' => 'aktif',
            ]
        );
    }
}