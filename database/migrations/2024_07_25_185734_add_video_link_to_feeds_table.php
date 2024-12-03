<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoLinkToFeedsTable extends Migration
{
    public function up()
    {
        Schema::table('feeds', function (Blueprint $table) {
            $table->string('video_link')->nullable()->after('content'); // Añadir columna para enlace de video
        });
    }

    public function down()
    {
        Schema::table('feeds', function (Blueprint $table) {
            $table->dropColumn('video_link');
        });
    }
}
