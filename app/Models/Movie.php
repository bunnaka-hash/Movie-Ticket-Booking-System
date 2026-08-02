<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


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

    /**
     * Shown when a movie has no poster, or its file is missing.
     */
    public const POSTER_PLACEHOLDER = 'images/posters/placeholder.svg';

    /**
     * Resolve `poster` to a URL a browser can actually load.
     *
     * The column holds three different kinds of value, so normalise them here
     * rather than in every view:
     *   - "posters/abc.jpg"  uploaded via the admin panel (public disk)
     *   - "batman.jpg"       a file dropped into public/images/posters
     *   - "https://..."      an external image
     */
    public function getPosterUrlAttribute(): string
    {
        $poster = trim((string) $this->poster);

        if ($poster === '') {
            return asset(self::POSTER_PLACEHOLDER);
        }

        if (Str::startsWith($poster, ['http://', 'https://', '//'])) {
            return $poster;
        }

        if (Str::startsWith($poster, 'storage/')) {
            return asset($poster);
        }

        if (Str::startsWith($poster, 'posters/')) {
            return asset('storage/'.$poster);
        }

        if (Str::startsWith($poster, '/')) {
            return url($poster);
        }

        return asset('images/posters/'.$poster);
    }

    /**
     * Placeholder URL for views to fall back to when an image 404s.
     */
    public function getPosterPlaceholderAttribute(): string
    {
        return asset(self::POSTER_PLACEHOLDER);
    }

    public function showtimes(): HasMany
    {
        return $this->hasMany(Showtime::class);
    }
}