<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Referidos extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipo_cargo',
        'documento',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    

}
