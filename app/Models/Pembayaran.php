<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'penyewa_id',
        'kamar_id',
        'jumlah',
        'status',
        'tanggal_bayar',
        'bulan',
        'tahun',
        'bukti_pembayaran',
        'keterangan'
    ];

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
}
