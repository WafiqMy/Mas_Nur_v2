<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $fillable = [
        'username',
        'role',
        'judul',
        'pesan',
        'link',
        'status_badge',
        'is_new',
        'tipe',
        'reference_id',
    ];

    protected $casts = [
        'is_new' => 'boolean',
    ];

    /**
     * Scope untuk filter notifikasi yang belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->where('is_new', true);
    }

    /**
     * Scope untuk filter notifikasi berdasarkan user
     */
    public function scopeForUser($query, string $username, ?string $role = null)
    {
        $query->where('username', $username);
        if ($role) {
            $query->where('role', $role);
        }
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope untuk filter notifikasi berdasarkan tipe
     */
    public function scopeByType($query, string $tipe)
    {
        return $query->where('tipe', $tipe);
    }

    /**
     * Mark notifikasi sebagai sudah dibaca
     */
    public function markAsRead()
    {
        $this->update(['is_new' => false]);
    }
}

