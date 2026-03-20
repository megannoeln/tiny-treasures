<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    /** @use HasFactory<\Database\Factories\ArtworkFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'year',
        'image_path',
        'is_featured',
        'is_for_sale',
        'price_cents',
        'is_sold',
    ];

    protected $casts = [
        'year' => 'integer',
        'is_featured' => 'boolean',
        'is_for_sale' => 'boolean',
        'price_cents' => 'integer',
        'is_sold' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

}
