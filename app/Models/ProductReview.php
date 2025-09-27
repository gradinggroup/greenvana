<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReview extends Model
{
    protected $fillable = [
        'products_id',
        'user_id',
        'name',
        'summary',
        'review',
        'rating_quality',
        'rating_price',
        'rating_value',
        'rating_overall',
        
    ];

    // Relasi
    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
