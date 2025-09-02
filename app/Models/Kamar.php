<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

// app/Models/Penyewa.php
public function user()
{
    return $this->belongsTo(User::class);
}

public function kamar()
{
    return $this->belongsTo(Kamar::class);
}

// app/Models/User.php
public function penyewa()
{
    return $this->hasOne(Penyewa::class);
}

public function isAdmin()
{
    return $this->role === 'admin';
}

public function isPenyewa()
{
    return $this->role === 'penyewa';
}
}