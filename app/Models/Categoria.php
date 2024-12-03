<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion'
    
    ];

    use HasFactory;


    public function incapacidades()
    {
        return $this->hasMany(Incapacidades::class);
    }
}
