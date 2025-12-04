<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dm_messages', function (Blueprint $table) {
            // artists テーブルが存在する前提
            $table->unsignedBigInteger('from_artist_id')->nullable()->after('from_user_id');
            $table->unsignedBigInteger('to_artist_id')->nullable()->after('to_user_id');

            $table->foreign('from_artist_id')->references('id')->on('artists')->onDelete('set null');
            $table->foreign('to_artist_id')->references('id')->on('artists')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('dm_messages', function (Blueprint $table) {
            $table->dropForeign(['from_artist_id']);
            $table->dropForeign(['to_artist_id']);
            $table->dropColumn(['from_artist_id', 'to_artist_id']);
        });
    }
};
