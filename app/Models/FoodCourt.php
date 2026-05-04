<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodCourt extends Model
{
    protected $table = 'food_court';
    protected $primaryKey = 'id_food';

    protected $fillable = [
        'nama_menu',
        'deskripsi',
        'gambar',
    ];

    /**
     * Mendapatkan URL gambar menu.
     */
    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar) {
            return asset('storage/food_court/' . $this->gambar);
        }
        return 'https://via.placeholder.com/400x300?text=No+Image';
    }
}
