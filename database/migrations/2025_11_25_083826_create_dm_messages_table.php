<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dm_messages', function (Blueprint $table) {
            $table->id();

            // どのスレッドのメッセージか
            $table->unsignedBigInteger('thread_id');

            // 送信者
            $table->unsignedBigInteger('from_user_id');

            // 受信者
            $table->unsignedBigInteger('to_user_id');

            // 本文
            $table->text('message');

            // 既読フラグ
            $table->boolean('is_read')->default(false);

            $table->timestamps();

            // 外部キー
            $table->foreign('thread_id')->references('id')->on('dm_threads')->onDelete('cascade');
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dm_messages');
    }
};
