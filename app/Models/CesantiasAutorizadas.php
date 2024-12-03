<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CesantiasAutorizadas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipo_cesantia_reportada',
        'estado',
        'justificacion',
        'uuid',
        'images',
        'cesantia_id', // Asegúrate de incluir la clave foránea
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cesantias(): BelongsTo
{
    return $this->belongsTo(Cesantias::class, 'cesantia_id');
}


 

}
