<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cedula',
        'email',
        'password',
        'rol_id',
        'is_active',
        'p_venta',
        'cargo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    

    public function perfil()
    {
        return $this->hasOne(Perfil::class);
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rol(){
        return $this->belongsTo(Rol::class,'rol_id'); 
    }

    public function incapacidades(): HasMany
    {
        return $this->hasMany(Incapacidades::class);
    }
    

    public function permisos(): HasMany
    {
        return $this->hasMany(PermisoRemunerado::class);
    }
    
    public function Cesantias(): HasMany
    {
        return $this->hasMany(Incapacidades::class);
    }

    
    public function Malla(): HasMany
    {
        return $this->hasMany(Malla::class);
    }

    public function Publicacion(): HasMany
    {
        return $this->hasMany(Publicacion::class);
    }

}
