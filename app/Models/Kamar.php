<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar';
    use HasFactory;

    protected $fillable = [
        'nomor_kamar',
        'harga',
        'fasilitas',
        'status'
    ];

    protected $casts = [
        'harga' => 'integer',
    ];
}