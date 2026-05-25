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
        Schema::table('artists', function (Blueprint $table) {
            // tiktok_link の後ろに、空（Null）を許可して niconico_link を追加
            $table->string('niconico_link')->nullable()->after('tiktok_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artists', function (Blueprint $table) {
            // ロールバック（元に戻す）したときにカラムを消去する処理
            $table->dropColumn('niconico_link');
        });
    }
};
