<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMallasTable extends Migration
{
    
    public function up()
    {
        Schema::create('mallas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('proceso');
            $table->string('p_venta');
            $table->string('documento');
            $table->string('estado')->nullable();
            $table->string('calificacion')->nullable();
            $table->timestamps();
        });
    }
    

    
    public function down()
    {
        Schema::dropIfExists('mallas');
    }
}
