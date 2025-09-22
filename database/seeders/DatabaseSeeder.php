<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@sikosan.com'],
            [
                'name' => 'Admin Kos',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Pemilik
        User::updateOrCreate(
            ['email' => 'pemilik@sikosan.com'],
            [
                'name' => 'Pemilik Kos',
                'password' => Hash::make('password'),
                'role' => 'pemilik',
            ]
        );

        // Penyewa
        User::updateOrCreate(
            ['email' => 'penyewa@sikosan.com'],
            [
                'name' => 'Penyewa Kos',
                'password' => Hash::make('password'),
                'role' => 'penyewa',
            ]
        );
    }
}
