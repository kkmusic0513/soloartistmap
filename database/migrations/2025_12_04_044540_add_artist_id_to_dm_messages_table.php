<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('dm_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('artist_id')->nullable()->after('from_user_id');

            $table->foreign('artist_id')
                ->references('id')->on('artists')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('dm_messages', function (Blueprint $table) {
            $table->dropForeign(['artist_id']);
            $table->dropColumn('artist_id');
        });
    }

};
