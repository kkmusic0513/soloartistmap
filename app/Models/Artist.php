<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'name',
        'main_photo',
        'sub_photo_1',
        'sub_photo_2',
        'prefecture',
        'genre',
        'profile',
        'official_website',
        'youtube_link',
        'soundcloud_link',
        'twitter_link',
    ];

    // protected $casts = [
    //     'photos' => 'array',
    // ];
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
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    public function videos()
    {
        return $this->hasMany(ArtistVideo::class);
    }

}
