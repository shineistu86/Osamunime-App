<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'anime_id',
        'title',
        'image_url',
        'score',
        'rating',
        'review',
        'status',
        'notes'
    ];

    protected $casts = [
        'score' => 'decimal:1',
        'rating' => 'integer',
    ];

    /**
     * Get the user that owns the favorite
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tags associated with the favorite
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'favorite_tag');
    }
}
