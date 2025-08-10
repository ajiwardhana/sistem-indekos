<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kamar;
use App\Models\Pembayaran;

class Penyewaan extends Model
{
    protected $fillable = [
        'user_id', 'kamar_id', 'tanggal_mulai', 'tanggal_selesai', 'status', 'total_pembayaran'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}