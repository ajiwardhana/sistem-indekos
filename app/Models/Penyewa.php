<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penyewaan extends Model
{
    protected $table = 'penyewaan';
    public function pembayaran()
{
    return $this->hasMany(Pembayaran::class);
}
}
