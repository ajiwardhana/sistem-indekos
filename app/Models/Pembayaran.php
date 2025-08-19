<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit
    protected $table = 'pembayaran';

    protected $fillable = [
        'penyewaan_id',
        'jumlah',
        'tanggal_pembayaran',
        'status',
        'bukti_pembayaran',
        'metode_pembayaran'
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'date',
        'jumlah' => 'integer'
    ];

    /**
     * Relationship ke model Penyewaan
     */
    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class);
    }
}