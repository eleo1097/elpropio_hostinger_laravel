<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Malla extends Model
{
   
    use HasFactory;

    // Definir la tabla que el modelo manejará (opcional si la tabla es plural de forma predeterminada)
    protected $table = 'mallas';

    // Definir los campos que se pueden asignar masivamente (mass assignable)
    protected $fillable = [
        'user_id',   // Añadir 'user_id' ya que este campo también debe ser asignado
        'proceso',
        'p_venta',
        'documento',  // Asegúrate de que el nombre del campo en la base de datos sea 'documento' y no 'documentos'
        'estado',
        'calificacion',

    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    
}


