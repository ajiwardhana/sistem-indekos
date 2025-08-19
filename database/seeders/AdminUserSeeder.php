<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Kos',
            'email' => 'ajiwardhana001@gmail.com',
            'password' => Hash::make('admin123'), // Ganti password
            'role' => 'admin',
            'email_verified_at' => now(),
            'phone' => '081234567890',
            'address' => 'Alamat admin'
        ]);

        $this->command->info('Admin user created successfully!');
    }
}