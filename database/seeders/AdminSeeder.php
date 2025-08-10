<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Utama',
            'email' => 'ajiwardhana001@gmail.com',
            'password' => Hash::make('admin123'), // Ganti dengan password kuat
            'role' => 'admin'
        ]);
    }
}