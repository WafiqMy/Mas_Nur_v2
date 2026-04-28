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
    ];

    protected $casts = [
        'is_new' => 'boolean',
    ];
}
