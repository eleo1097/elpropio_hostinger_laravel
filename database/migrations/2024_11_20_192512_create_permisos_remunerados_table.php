<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisosRemuneradosTable extends Migration
{
    /**
     * Ejecutar las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permiso_remunerados', function (Blueprint $table) {
            $table->id();  // Auto incremental por defecto
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users'); // Relación con users
            $table->string('p_venta');  // P Venta
            $table->string('categoria_solicitud');  // Categoría de solicitud
            $table->integer('tiempo_requerido');  // Tiempo requerido
            $table->string('unidad_tiempo');  // Unidad de tiempo (por ejemplo: horas, días, etc.)
            $table->string('hora')->nullable(); //
            $table->date('fecha_permiso');
            $table->date('fecha_solicitud');
            $table->string('estado')->nullable();  // Estado del permiso (por ejemplo: solicitado, aprobado, rechazado)
            $table ->string('justificacion');
            $table->timestamps();  // Timestamps de creación y actualización
        });
    }

    /**
     * Deshacer las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permiso_remunerados');
    }
}
