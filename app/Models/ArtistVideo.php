<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistVideo extends Model
{
    protected $fillable = [
        'artist_id',
        'title',
        'youtube_url',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}

