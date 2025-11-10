<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistPhoto extends Model
{
    protected $fillable = ['artist_id', 'path'];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
