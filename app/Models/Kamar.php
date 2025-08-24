<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';

    protected $fillable = [
        'nomor_kamar',
        'tipe',
        'harga',
        'status',
        'fasilitas',
        'foto'
    ];

    protected $casts = [
        'harga' => 'integer'
    ];

    /**
     * Relationship ke model Penyewaan
     */
    public function penyewa()
    {
        return $this->hasMany(Penyewaan::class);
    }

    public function kamar()
    {
        return $this->belongsTo(kamar::class);
    }

    /**
     * Get URL foto
     */
    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}