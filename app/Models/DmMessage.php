<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DmMessage extends Model
{
    protected $fillable = [
        'thread_id',
        'from_user_id',
        'to_user_id',
        'from_artist_id',
        'to_artist_id',
        'message',
        'image_path', // ← 追加
        'is_read',
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function fromArtist()
    {
        return $this->belongsTo(Artist::class, 'from_artist_id');
    }

    public function toArtist()
    {
        return $this->belongsTo(Artist::class, 'to_artist_id');
    }
}

