<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $casts = [
    'tanggal_pembayaran' => 'datetime', // Cast ke format date
];
    protected $fillable = [
        'penyewaan_id', 'jumlah', 'tanggal_pembayaran', 'metode_pembayaran', 'bukti_pembayaran', 'status'
    ];

    public function penyewa()
{
    return $this->belongsTo(Penyewa::class);
}

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}