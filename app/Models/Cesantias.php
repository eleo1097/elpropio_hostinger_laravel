<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Cesantias extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'tipo_cesantia_reportada',
        'estado',
        'justificacion',
        'uuid',
        'documentos',
    ];
    

    protected $casts = [
        'images' => 'array', 
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    
    public function images(): HasMany
    {
        return $this->hasMany(CesantiasImages::class);
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(CesantiasDocumentos::class);
    }
}

