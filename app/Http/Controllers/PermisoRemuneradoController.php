<?php

namespace App\Http\Controllers;

use App\Models\PermisoRemunerado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class PermisoRemuneradoController extends Controller
{
    /**
     * Mostrar una lista de los permisos remunerados.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    // Obtener todos los permisos remunerados con solo el nombre y la cédula del usuario
    $permisos = PermisoRemunerado::with(['user:id,name,cedula'])->get();

    // Retornar la respuesta con los permisos y los datos seleccionados del usuario
    return response([
        'permisos' => $permisos
    ], 200, [], JSON_NUMERIC_CHECK);
}







    public function indexAuth()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener los permisos remunerados del usuario autenticado
        $permisos = PermisoRemunerado::where('user_id', $user->id)->get();

        // Retornar la respuesta con los permisos de ese usuario
        return response([
            'permisos' => $permisos
        ], 200, [], JSON_NUMERIC_CHECK);
    }
  

    public function store(Request $request)
    {

        try{
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'p_venta' => 'required|string',
                'categoria_solicitud' => 'required|string',
                'tiempo_requerido' => 'required|integer',
                'unidad_tiempo' => 'required|string',
                'fecha_permiso' => 'required|date',
                'fecha_solicitud' => 'required|date',
                'justificacion' => 'required|string',
            ]);
    
            // Crear el permiso remunerado
            PermisoRemunerado::create($request->all());

            return response(['message' => 'Permiso creado exitosamente'], 201);


        }catch(Exception $e) {
            // Mostrar el error y la traza del error
            return response(['message' => 'error', 'error' => $e->getMessage(), 'trace' => $e->getTrace()], 500);
        }
        // Validación de datos
       

    }

 
  
  
    public function update(Request $request, $id)
    {
        $permisos = PermisoRemunerado::find($id);
        if (!$permisos) {
            return response(['message' => 'Permiso no encontrado'], 404);
        }

        if ($request->has('estado')) {
            $permisos->estado = $request->estado;
        }

        $permisos->save();

        return response(['message' => 'Estado actualizado exitosamente'], 200);
    }



    
    public function destroy( $id)
    {
        $permisos = PermisoRemunerado::find($id);
        $permisos->delete();
        return response(['message' => 'Permiso eliminado exitosamente'], 200);
    }
}
