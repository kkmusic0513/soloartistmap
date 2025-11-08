<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    
    protected $fillable = [
    'name',
    'prefecture',
    'genre',
    'profile',
    'youtube_link',
    'soundcloud_link',
    'twitter_link',
    'is_approved',
    ];
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
}
