<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoRemunerado extends Model
{
    use HasFactory;



    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'p_venta',
        'categoria_solicitud',
        'tiempo_requerido',
        'unidad_tiempo',
        'hora',
        'fecha_permiso',
        'fecha_solicitud',
        'justificacion',

    ];

    // Relación con el modelo User (si quieres acceder al usuario relacionado)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
