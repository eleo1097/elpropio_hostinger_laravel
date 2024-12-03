<?php
namespace App\Service;

use Illuminate\Support\Facades\Auth;

class FuncionesService
{
    public function obtenerIdUserAutenticado() {
        
        $user = Auth::user();
        if ($user && $user->user) {
            return $user->user->id;
        }

        return null;
    }

}