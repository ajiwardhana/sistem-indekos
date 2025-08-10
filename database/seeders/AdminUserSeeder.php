<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
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