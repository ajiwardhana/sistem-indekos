<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    public function pembayaran()
{
    return $this->hasMany(Pembayaran::class);
}
}
