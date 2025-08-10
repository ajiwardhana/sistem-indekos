<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
{
    // Buat user admin manual
    \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'ajiwardhana001@gmail.com',
        'password' => bcrypt('password123'),
        'role' => 'admin',
    ]);

    // Buat sample user biasa
    \App\Models\User::factory(10)->create(); // Membuat 10 user biasa
    }
}