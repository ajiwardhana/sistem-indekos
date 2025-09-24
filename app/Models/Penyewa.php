<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kamar_id',
        'tanggal_masuk',
        'tanggal_keluar',
    ];

    protected $dates = ['tanggal_masuk', 'tanggal_keluar'];

        protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tanggal_keluar' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function pembayarans()
{
    return $this->hasMany(Pembayaran::class);
}
}
