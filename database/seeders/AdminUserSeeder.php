<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin kos',
            'email' => 'ajiwardhana001@gmail.com',
            'password' => Hash::make('admin'), // Ganti dengan password yang aman
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        
        $this->command->info('Admin user created successfully!');
    }
}