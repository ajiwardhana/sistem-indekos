<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    // Tentukan nama tabel yang benar
    protected $table = 'pembayaran';

    protected $fillable = [
        'penyewaanan_id',
        'jumlah',
        'tanggal_pembayaran',
        'metode_pembayaran',
        'bukti_pembayaran',
        'status'
    ];

    /**
     * Relasi ke model Penyewaan
     */
    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class);
    }
}