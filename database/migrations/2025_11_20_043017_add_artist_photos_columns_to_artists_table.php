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
            $table->string('main_photo')->nullable()->after('photos');
            $table->string('sub_photo_1')->nullable()->after('main_photo');
            $table->string('sub_photo_2')->nullable()->after('sub_photo_1');
        });
    }

    public function down(): void
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn('main_photo');
            $table->dropColumn('sub_photo_1');
            $table->dropColumn('sub_photo_2');
        });
    }
};
