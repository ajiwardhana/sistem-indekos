<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $fillable = [
        'nomor_kamar', 'tipe', 'harga', 'fasilitas', 'status'
    ];

    public function penyewaan()
{
    return $this->hasMany(Penyewaan::class);
}

    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }
    public function scopeTidakTersedia($query)
    {
        return $query->where('status', 'tidak tersedia');
    }

}