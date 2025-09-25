<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kamar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@sikosan.com'],
            [
                'name' => 'Admin Sikosan',
                'password' => Hash::make('123123'),
                'role' => 'admin',
                'no_telepon' => '081234567890',
                'alamat' => 'Alamat Admin'
            ]
        );

        // Pemilik
        User::updateOrCreate(
            ['email' => 'pemilik@sikosan.com'],
            [
                'name' => 'Pemilik Kos',
                'password' => Hash::make('password'),
                'role' => 'pemilik',
                'no_telepon' => '081298765432',
                'alamat' => 'Alamat Pemilik'
            ]
        );

        // Penyewa
        User::updateOrCreate(
            ['email' => 'penyewa@sikosan.com'],
            [
                'name' => 'Penyewa Kos',
                'password' => Hash::make('123123'),
                'role' => 'penyewa',
                'no_telepon' => '08111222333',
                'alamat' => 'Alamat Penyewa'
            ]
        );

        // Data Sample Kamar
        Kamar::updateOrCreate(
            ['nomor_kamar' => 'A01'],
            [
                'harga' => 1500000,
                'status' => 'tersedia',
                'fasilitas' => 'Kamar Mandi Dalam, AC, WiFi, Kasur, Lemari, Meja',
                'deskripsi' => 'Kamar nyaman dengan AC dan kamar mandi dalam',
            ]
        );

        Kamar::updateOrCreate(
            ['nomor_kamar' => 'A02'],
            [
                'harga' => 1200000,
                'status' => 'tersedia',
                'fasilitas' => 'Kamar Mandi Luar, Kipas Angin, WiFi, Kasur, Lemari',
                'deskripsi' => 'Kamar ekonomis dengan kamar mandi luar',
            ]
        );

        Kamar::updateOrCreate(
            ['nomor_kamar' => 'B01'],
            [
                'harga' => 2000000,
                'status' => 'terisi',
                'fasilitas' => 'Kamar Mandi Dalam, AC, WiFi, Kasur King Size, Lemari Besar, TV',
                'deskripsi' => 'Kamar premium dengan fasilitas lengkap',
            ]
        );
    }
}