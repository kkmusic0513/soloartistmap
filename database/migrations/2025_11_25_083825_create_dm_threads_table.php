<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dm_threads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user1_id');
            $table->unsignedBigInteger('user2_id');
            $table->timestamps();

            // 同じ2人の組み合わせを重複させない
            $table->unique(['user1_id', 'user2_id']);

            // 外部キー（userテーブル本体）
            $table->foreign('user1_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user2_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dm_threads');
    }
};
