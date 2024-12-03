<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{

    protected $fillable = [
        'name',
        'cedula',
        'email',
        'rol_id',
        
    ];

  
    public $timestamps = false;

    protected $table = "perfiles";
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    use HasFactory;
}