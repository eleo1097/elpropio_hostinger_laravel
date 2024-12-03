<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perfil;
use App\Service\FuncionesService;


use Illuminate\Http\Request;

class PerfilController extends Controller
{

    private $service;

     // Inyección de dependencias del servicio FuncionesService 
    public function __construct(FuncionesService $service){
        $this->service = $service;
    }

     // Método para almacenar un perfil asociado a un usuario autenticado
    public function store(Request $request)
{
    $user = auth()->user();

    // Crear un perfil asociado al usuario autenticado
    $perfil = $user->perfil()->create([
        'name' => $request->name,
        'cedula' => $request->cedula,
        'email' => $request->email,
        'rol_id' => $request->rol_id,
        'p_venta' => $request->p_venta,
        'cargo' => $request->cargo
    ]);

    return response()->json($perfil, 201);
}


// Método para obtener el perfil del usuario autenticado
public function verPerfil()
{
    $user_id = $this->service->obtenerIdUserAutenticado();
        if (!$user_id) {
            return response()->json(["error" => "Usuario no autorizado"],403);
        }
        $perfiles = User::find($user_id)->perfil;
        if ($perfiles) {
            return response()->json($perfiles, 200);
        }
        return response()->json(["error"=>"Perfil no encontrado"], 404);
}


    // Método para actualizar el perfil del usuario autenticado
    public function update(Request $request)
    {
        $user = auth()->user();

        $perfil = $user->perfil;

        if (!$perfil) {
            return response()->json(["error" => "Perfil no encontrado"], 404);
        }

        $perfil->name = $request->name;
        $perfil->cedula = $request->cedula;
        $perfil->email = $request->email;
        
        $perfil->save();


        return response()->json($perfil, 200);
    }

    // Método para eliminar el perfil del usuario autenticado
    public function destroy()
    {
        $user = auth()->user();

        $perfil = $user->perfil;

        if ($perfil) {
            $perfil->delete();
            return response()->json("Perfil eliminado", 200);
        }

        return response()->json(["error" => "Perfil no encontrado"], 404);
    }

}
