<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('artist_id')->constrained()->onDelete('cascade'); // アーティストID
            $table->string('title'); // イベント名
            $table->text('description')->nullable(); // 詳細
            $table->dateTime('start_at'); // 開始日時
            $table->dateTime('end_at')->nullable(); // 終了日時
            $table->string('location')->nullable(); // 開催場所
            $table->string('photo')->nullable(); // 写真
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
