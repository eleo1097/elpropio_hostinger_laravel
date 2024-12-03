<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCesantiasTable extends Migration
{
    
    public function up()
    {
        Schema::create('cesantias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('tipo_cesantia_reportada',50)->nullable();
            $table->string('estado', 50)->nullable(); 
            $table->string('justificacion',500)->nullable();
            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('cesantias_images', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('cesantias_id');
            $table->foreign('cesantias_id')->references('id')->on('cesantias')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();

        });

        Schema::create('cesantias_documentos', function ($table){

            $table->bigIncrements('id');
            $table->unsignedBigInteger('cesantias_id');
            $table->foreign('cesantias_id')->references('id')->on('cesantias')->onDelete('cascade');
            $table->string('documentos');
            $table->timestamps();
        }
    
    );


    }


    public function down()
    {
        Schema::dropIfExists('cesantias_images');
        Schema::dropIfExists('cesantias');
    }
}




