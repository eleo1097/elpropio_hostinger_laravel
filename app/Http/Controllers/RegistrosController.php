<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Str;
use App\Models\Incapacidades;
use App\Http\Requests\IncapacidadesRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\PermisoRemunerado;
use App\Models\Malla;
use App\Models\Cesantias;

use Illuminate\Database\Eloquent\Relations\HasMany;

class RegistrosController extends Controller
{

    
    public function indexcesantias()
    {
        $user =Auth::user();

        $cesantias = Cesantias::with('user','images')
         ->where('user_id',$user->id)
         ->get();

        ;

        $cesantias->each(function ($cesantias){
            if ($cesantias->images){
                $cesantias->images->each(function ($image){
                    $image->image_path = '/storage/'. $image->image_path;

                });
            }


            if ($cesantias->documentos) {
                $cesantias->documentos->each(function($documento) {
                    $documento->documentos = '/storage/' . $documento->documentos; // Ajusta la ruta según tu almacenamiento
                });
            }

        });

        return response([
            'cesantias' => $cesantias
        ], 200, [], JSON_NUMERIC_CHECK);

   
    }

    

    public function indexincapacidades()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener las incapacidades del usuario autenticado
        $incapacidades = Incapacidades::with('user', 'images')
            ->where('user_id', $user->id)
            ->get();

        // Iterar sobre cada incapacidad
        $incapacidades->each(function($incapacidad) {
            // Verificar si tiene imágenes antes de iterar
            if ($incapacidad->images) {
                $incapacidad->images->each(function($image) {
                    $image->image_path = '/storage/' . $image->image_path;
                });
            }

            if ($incapacidad->documentos) {
                $incapacidad->documentos->each(function($documento) {
                    $documento->documentos = '/storage/' . $documento->documentos; // Ajusta la ruta según tu almacenamiento
                });
            }
        });

        return response([
            'incapacidades' => $incapacidades
        ], 200, [], JSON_NUMERIC_CHECK);
    }



    

    public function indexPermisos()
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

    
    public function indexMallas()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener los permisos remunerados del usuario autenticado
        $mallas = Malla::where('user_id', $user->id)->get();

        // Retornar la respuesta con los permisos de ese usuario
        return response([
            'mallas' => $mallas
        ], 200, [], JSON_NUMERIC_CHECK);
    }
  
  

    
}
