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
     * Get the favorites that belong to this tag
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Favorite::class, 'favorite_tag');
    }
}
