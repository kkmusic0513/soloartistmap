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
            $table->integer('is_approved')->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->tinyInteger('is_approved')->default(0)->change();
        });
    }
};
