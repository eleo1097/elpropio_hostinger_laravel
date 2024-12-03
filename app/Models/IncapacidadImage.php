<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class IncapacidadImage extends Model
{
    use HasFactory;


    protected $fillable = [
        'incapacidades_id',
        'image_path',
    ];

    public function incapacidad(): BelongsTo
    {
        return $this->belongsTo(Incapacidad::class);
    }
}
