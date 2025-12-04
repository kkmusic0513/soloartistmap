<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DmThread extends Model
{
    protected $fillable = [
        'user1_id',
        'user2_id',
    ];

    // スレッドのメッセージ一覧
    public function messages(): HasMany
    {
        return $this->hasMany(DmMessage::class, 'thread_id')->orderBy('created_at', 'asc');
    }

    // ユーザー1
    public function user1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    // ユーザー2
    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user2_id');
    }
    //未読既読システム
    public function getUnreadCountAttribute()
    {
        return $this->messages()
            ->where('to_user_id', auth()->id())
            ->where('is_read', false)
            ->count();
    }
    public function unreadCountFor($userId)
    {
        return $this->messages()
            ->where('to_user_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    // スレッド内の最新メッセージ日時（一覧のソート用）
    public function latestMessageDate()
    {
        return optional($this->messages()->orderBy('created_at', 'desc')->first())->created_at;
    }

}
