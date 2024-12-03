<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResetPinToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('reset_pin')->nullable(); // Asegúrate de usar un campo adecuado
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('reset_pin');
    });
}

}
