<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncapacidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incapacidades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users'); // Relación con users
            $table->string('tipo_incapacidad_reportada', 50);
            $table->integer('dias_incapacidad');
            $table->date('fecha_inicio_incapacidad');
            $table->boolean('aplica_cobro')->nullable();
            $table->string('identificador_incapacidad')->nullable();
            $table->string('entidad_afiliada', 50);
            $table->string('tipo_incapacidad', 50)->nullable();
            $table->uuid('uuid')->unique(); // UUID único
            $table->unsignedBigInteger('categoria_id')->nullable();  // Asegúrate de definir esta columna
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');  // Relación con categorias         $table->timestamps();
            $table->timestamps();
        });

        Schema::create('incapacidad_images', function (Blueprint $table){

            $table->bigIncrements('id');
            $table->unsignedBigInteger('incapacidades_id');
            $table->foreign('incapacidades_id')->references('id')->on('incapacidades')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });


        Schema::create('incapacidad_documentos', function ($table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('incapacidades_id');
            $table->foreign('incapacidades_id')->references('id')->on('incapacidades')->onDelete('cascade');
            $table->string('documentos');
            $table->timestamps();
        } );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incapacidad_images');
        Schema::dropIfExists('incapacidades');

    }
}
