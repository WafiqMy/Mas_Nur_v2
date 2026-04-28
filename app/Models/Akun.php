<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Akun extends Authenticatable
{
    use Notifiable;

    protected $table = 'akun';

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'no_telpon',
        'role',
        'status',
        'gambar',
        'otp',
        'otp_expired',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    protected $casts = [
        'otp_expired' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar && file_exists(storage_path('app/public/profil_user/' . $this->gambar))) {
            return asset('storage/profil_user/' . $this->gambar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&background=random&color=fff&size=128';
    }
}
