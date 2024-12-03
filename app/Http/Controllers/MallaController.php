<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Asegúrate de importar Validator
use App\Models\Malla;

class MallaController extends Controller
{


    




    // Mostrar todas las mallas
    public function index()
    {

        
        $mallas = Malla::with(['user:id,name,cedula'])->get();

        return response([
            'malla' => $mallas
        ], 200,[], JSON_NUMERIC_CHECK);
    }

    // Crear una nueva malla
    public function store(Request $request)
{
    // Usar Validator en lugar de Valitador
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|integer',
        'proceso' => 'required|string',
        'p_venta' => 'required|string',
        'documento' => 'required|file|mimes:pdf|max:10240'  // Asegúrate de validar el archivo PDF
    ]);

    if ($validator->fails()) {
        return response(['message' => 'Validation error', 'errors' => $validator->errors()], 422);
    }

    try {
        // Verificar si se ha recibido un archivo
        if ($request->hasFile('documento') && $request->file('documento')->isValid()) {
            // Guardar el documento PDF
            $documentoFile = $request->file('documento');
            $documentoName = $documentoFile->getClientOriginalName();
            $documentoPath = $documentoFile->storeAs('mallas_folder', $documentoName, 'public'); // Guardar el archivo

            // Crear la malla con los datos recibidos
            $malla = Malla::create([
                'user_id' => $request->user_id,
                'proceso' => $request->proceso,
                'p_venta' => $request->p_venta,
                'documento' => $documentoName  // Guardar el nombre del archivo en la base de datos
            ]);

            return response()->json($malla, 201);
        } else {
            return response()->json(['error' => 'No file uploaded or file is invalid'], 400);
        }
    } catch (\Exception $e) {
        // Si ocurre un error en el proceso, regresamos un mensaje con detalles
        return response()->json(['error' => 'Error al subir la malla', 'message' => $e->getMessage()], 500);
    }
}


    // Descargar el documento
    public function downloadDocumento($id)
    {
        try {
            $malla = Malla::findOrFail($id);

            // Verificar si el archivo existe en el sistema de almacenamiento
            $documentoPath = storage_path('app/public/mallas_folder/' . $malla->documento);

            if (!file_exists($documentoPath)) {
                return response()->json(['error' => 'El archivo solicitado no existe'], 404);
            }

            // Obtener el nombre original del archivo
            $originalName = $malla->documento;

            // Descargar el archivo con el nombre original
            return response()->download($documentoPath, $originalName);
        } catch (\Exception $e) {
            Log::error('Error al descargar el documento: ' . $e->getMessage());
            return response()->json(['error' => 'Error al descargar el documento'], 500);
        }
    }

    public function calificar(Request $request, $id)
    {
        $malla = Malla::find($id);

        if (!$malla){
            return response()->json(['error' => 'La malla no existe'], 404);
        }

        if ($request->has('calificacion')){
            $malla->calificacion = $request->calificacion;            
        }

        $malla->save();

        return response()->json($malla);

    }

    public function estado(Request $request, $id){
        $malla = Malla::find($id);

        if (!$malla){
            return response()->json(['error' => 'La malla no existe'], 404);
        }

        if ($request->has('estado')){
            $malla->estado = $request->estado;            
        }

        $malla->save();

        return response()->json($malla);
    }


    // Eliminar una malla
    public function destroy($id)
    {
        $malla = Malla::find($id);
        $malla->delete();
        return response()->json(null, 204);
    }
}
