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
        // 既存の artists テーブルを変更します
        Schema::table('artists', function (Blueprint $table) {
            // 文字列型から、複数データが入る text（または json）型へ変更
            $table->text('genre')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artists', function (Blueprint $table) {
            // ロールバックしたときは、元の単一文字列（string）に戻す
            // すでに複数選択データが入っている場合、元に戻すとデータが壊れる可能性があるので注意
            $table->string('genre')->nullable()->change();
        });
    }
};