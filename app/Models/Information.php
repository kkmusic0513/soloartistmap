<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    // テーブル名が単数形のModel名から自動推測（informations）されるので通常は不要ですが、
    // 念のため明示しておくと安心です。
    protected $table = 'informations';

    // 一括代入（Information::create など）を許可するカラムを指定
    protected $fillable = [
        'title',      // お知らせのタイトル
        'content',    // 内容
        'category',   // news, event, update などの区分
        'is_public',  // 公開・非公開
        'banner_image', // 追記
        'external_url', // 追記
    ];

    // キャスト設定：is_public を true/false として扱いやすくする
    protected $casts = [
        'is_public' => 'boolean',
    ];
}
