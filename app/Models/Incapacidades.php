<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Incapacidades extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'tipo_incapacidad_reportada',
        'dias_incapacidad',
        'fecha_inicio_incapacidad',
        'aplica_cobro',
        'identificador_incapacidad',
        'entidad_afiliada',
        'tipo_incapacidad',
        'uuid',
        'images',
        'documentos',
        'categoria_id',
    ];

    protected $casts = [
        'images' => 'array', // Cast JSON field to array
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(IncapacidadImage::class);
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(IncapacidadDocumentos::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
