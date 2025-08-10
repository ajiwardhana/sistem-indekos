<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\User::create([
        'name' => 'Admin Kosan',
        'email' => 'ajiwardhana001@gmail.com',
        'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
        'role' => 'admin',
    ]);
}
}