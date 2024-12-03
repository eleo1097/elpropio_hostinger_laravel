<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class IncapacidadDocumentos extends Model
{
    use HasFactory;

    protected $fillable = [
        'incapacidades_id',
        'documentos',
    ];

    public function incapacidad(): BelongsTo
    {
        return $this->belongsTo(Incapacidad::class);
    }



}
