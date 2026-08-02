<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Movie extends Model
{
    protected $fillable = [
        'title',
        'description',
        'genre',
        'duration',
        'language',
        'release_date',
        'poster',
        'trailer_url',
        'rating',
        'status'
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    protected $appends = ['poster_url'];

    public function getPosterUrlAttribute()
    {
        return $this->poster ?? '/images/posters/placeholder.jpg';
    }

    public function showtimes(): HasMany
    {
        return $this->hasMany(Showtime::class);
    }
}