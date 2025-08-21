<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'address'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function penyewaan()
{
    return $this->hasMany(Penyewaan::class, 'user_id')->where('status', 'aktif');
}


    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is regular user
     */
    public function isUser()
    {
        return $this->role === 'user';
    }

    // Relasi jika diperlukan
    public function kamar()
    {
        return $this->hasMany(Kamar::class, 'user_id');
    }
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'user_id');
    }
}