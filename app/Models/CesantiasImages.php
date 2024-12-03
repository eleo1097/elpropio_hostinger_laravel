<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class CesantiasImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'cesantias_id',
        'image_path',
    ];
    
        
        public function cesantias(): BelongsTo
        {
            return $this->belongsTo(Cesantias::class);
        }
}
