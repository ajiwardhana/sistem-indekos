<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'penyewaan_id', 'jumlah', 'tanggal_pembayaran', 'metode_pembayaran', 'bukti_pembayaran', 'status'
    ];

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class);
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}