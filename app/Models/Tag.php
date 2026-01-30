<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * Mendapatkan favorit yang terkait dengan tag ini
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Favorite::class, 'favorite_tag');
    }
}
