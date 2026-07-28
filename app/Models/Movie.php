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

    public function showtimes(): HasMany
    {
        return $this->hasMany(Showtime::class);
    }
}