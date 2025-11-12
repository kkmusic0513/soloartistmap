<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'prefecture', 'genre', 'profile',
        'youtube_link', 'soundcloud_link', 'twitter_link',
        'photos',
    ];

    protected $casts = [
        'photos' => 'array', // JSON → 配列で取得可能
    ];
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
    public function photos()
    {
        return $this->hasMany(ArtistPhoto::class);
    }
    // app/Models/Artist.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
