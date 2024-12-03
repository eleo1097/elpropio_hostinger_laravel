<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class CesantiasDocumentos extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'cesantias_id',
        'documentos',
    ];

    public function cesantias(): BelongsTo
    {
        return $this->belongsTo(Cesantias::class);  // Assuming Cesantias is the name of your model. Replace it with the actual model name.  // Assuming CesantiasDocumentos has a foreign key 'cesantias_id' on the 'cesantias' table. Replace it with the actual foreign key field name.  // Assuming CesantiasDocumentos has a 'documentos' field to store the document. Replace it with the actual field name.  // Assuming CesantiasDocumentos has a 'cesantias' relationship to Cesantias. Replace it with the actual relationship name.  // Assuming CesantiasDocumentos has a 'cesantias_id' field to reference the 'cesantias' table. Replace it with the actual foreign key field name.  // Assuming CesantiasDocumentos has a 'documentos' field to store the document.
    }
}

