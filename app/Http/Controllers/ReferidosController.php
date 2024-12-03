<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Referidos;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Storage; 



class ReferidosController extends Controller
{
    

    //Mostrar Referidos
    public function index()
    {
        $referidos = Referidos::with('user')->latest()->get();
        return response([
            'referidos' => $referidos
        ], 200,[], JSON_NUMERIC_CHECK);

    }


       
    public function update(Request $request, $id){
        $referidos = Referidos::find($id);

        if (!$referidos) {
            return response()->json(['error' => 'Referido no encontrado'], 404);
        }

        // Solo actualiza los campos específicos si están presentes en la solicitud
        if ($request->has('estado')){
            $referidos->estado = $request->estado;
        }

        $referidos->save();

        return response()->json($referidos);
        

    }
    

   
    //Almacenar Referidos
    public function store(Request $request)
    {
        Log::info('Datos recibidos en la solicitud:', $request->all());
    
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|integer',
            'documento' => 'required|file|mimes:pdf|max:30000'
        ]);
    
        if ($validator->fails()){
            return response()->json(['error'=> $validator->errors() ],422);
        }
    
        try {
            // Guardar el documento PDF
            $documentoFile = $request->file('documento');
            $documentoName = $documentoFile->getClientOriginalName();
            $documentoFile->storeAs('referidos_folder', $documentoName, 'public');
    
            // Crear el referido en la base de datos
            $referido = Referidos::create([
             
                'documento' => $documentoName,
                'user_id' => $request->user_id
            ]);
    
            return response()->json($referido, 201);
        } catch (\Exception $e) {
            Log::error('Error al crear el Referido: '. $e->getMessage());
            return response()->json(['error' => 'Error al crear el referido, detalles en el registro de errores'], 500);
        }
    }
    

    public function downloadDocumento($id)
    {
        try {
            $referido = Referidos::findOrFail($id);
    
            // Verificar si el archivo existe en el sistema de almacenamiento
            $documentoPath = storage_path('app/public/referidos_folder/' . $referido->documento);
    
            if (!file_exists($documentoPath)) {
                return response()->json(['error' => 'El archivo solicitado no existe'], 404);
            }
    
            // Obtener el nombre original del archivo
            $originalName = $referido->documento;
    
            // Descargar el archivo con el nombre original
            return response()->download($documentoPath, $originalName);
        } catch (\Exception $e) {
            Log::error('Error al descargar el documento del referido: ' . $e->getMessage());
            return response()->json(['error' => 'Error al descargar el documento del referido'], 500);
        }
    }
    
 




    //Eliminar el referido 
    public function destroy($id)
    {

    }







}
