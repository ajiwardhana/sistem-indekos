<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    // ✅ Kalau migration pakai plural (kamars), property ini bisa dihapus
    protected $table = 'kamars';

    // Field yang bisa diisi mass-assignment
    protected $fillable = [
        'nomor_kamar',
        'tipe',
        'harga',
        'status',
        'fasilitas',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Satu kamar bisa ditempati satu penyewa (optional)
    public function penyewa()
{
    return $this->hasOne(Penyewa::class);
}

public function pembayarans()
{
    return $this->hasMany(Pembayaran::class);
}

}
