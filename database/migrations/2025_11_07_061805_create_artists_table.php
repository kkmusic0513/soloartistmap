<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('prefecture');
            $table->string('genre')->nullable();
            $table->text('profile')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('soundcloud_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->boolean('is_approved')->default(false); // 承認状態
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
