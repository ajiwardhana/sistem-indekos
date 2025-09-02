<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@indekos.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Tambahkan user contoh lainnya jika perlu
        DB::table('users')->insert([
            'name' => 'Pemilik Kos Contoh',
            'email' => 'pemilik@indekos.com',
            'password' => Hash::make('pemilik123'),
            'role' => 'pemilik',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('users')->insert([
            'name' => 'Penyewa Contoh',
            'email' => 'penyewa@indekos.com',
            'password' => Hash::make('penyewa123'),
            'role' => 'penyewa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}