<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamarFoto extends Model
{
    use HasFactory;

    protected $fillable = ['kamar_id', 'foto'];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
}
