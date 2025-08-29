<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    use HasFactory;

    protected $table = 'penyewaan';

    protected $fillable = [
        'user_id',
        'kamar_id',
        'tanggal_mulai',
        'durasi',
        'total_harga',
        'status'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'total_harga' => 'decimal:2',
    ];

    /**
     * Relationship ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship ke Kamar
     */
    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
}