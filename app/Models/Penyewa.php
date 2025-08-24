<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    protected $table = 'penyewa';
    public function pembayaran()
{
    return $this->hasMany(Pembayaran::class);
}
}
