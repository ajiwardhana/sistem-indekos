<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $fillable = [
        'nomor_kamar',
        'tipe',
        'harga',
        'status',
        'fasilitas',
        'deskripsi'
    ];

    public function penyewa()
    {
        return $this->hasOne(Penyewa::class);
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function fotos()
    {
        return $this->hasMany(KamarFoto::class);
    }

}
