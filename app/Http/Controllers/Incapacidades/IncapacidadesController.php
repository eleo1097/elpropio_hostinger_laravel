<?php

namespace App\Http\Controllers\Incapacidades;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Http\Requests\IncapacidadesRequest;

//modelos
use App\Models\Incapacidades;
use App\Models\IncapacidadImage;
use App\Models\IncapacidadDocumentos;
use App\Models\Categoria;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class IncapacidadesController extends Controller
{
   
    public function indexAll()
{
    // Obtener todas las incapacidades con las relaciones de usuario e imágenes
    $incapacidades = Incapacidades::with('user', 'images')->get();

    // Iterar sobre cada incapacidad
    $incapacidades->each(function($incapacidad) {
        // Verificar si tiene imágenes antes de iterar
        if ($incapacidad->images) {
            $incapacidad->images->each(function($image) {
                $image->image_path = '/storage/' . $image->image_path; // Ajusta la ruta según tu almacenamiento
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

public function consultarCodigoCategoria($codigoCategoria)
{
    // Log para saber que la consulta se inició
    \Log::info("Consultando código de categoría: $codigoCategoria");

    // Consultar la categoría por su código
    $categoria = Categoria::where('codigo', $codigoCategoria)->first();

    // Si la categoría no existe, retornar un error
    if (!$categoria) {
        \Log::warning("Código de categoría no encontrado: $codigoCategoria");
        return response()->json(['message' => 'Este código de categoría no existe. Solicítalo con tu EPS.'], 404);
    }

    // Si se encuentra la categoría, devolverla
    \Log::info("Código de categoría encontrado: $codigoCategoria");
    return $categoria;
}


public function store(Request $request)
{
    try {
        // Validar los datos entrantes
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'tipoincapacidadreportada' => 'required|string|max:50',
            'diasIncapacidad' => 'required|integer',
            'fechaInicioIncapacidad' => 'required|date',
            'entidadAfiliada' => 'required|string|max:50',
            'categoria_codigo' => 'required|string',  // Ahora acepta cualquier cadena
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Si la validación falla, retorna un error
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        // Obtener el código de la categoría
        $codigoCategoria = $request->categoria_codigo;

        // Depuración: Verificar el código de categoría recibido
        \Log::info('Código de categoría recibido:', ['codigoCategoria' => $codigoCategoria]);

        // Consultar la categoría por su código
        $categoria = Categoria::where('codigo', $codigoCategoria)->first();

        // Depuración: Verificar si la categoría fue encontrada
        if (!$categoria) {
            return response()->json(['message' => 'Este código de categoría no existe. Solicítalo con tu EPS.'], 404);
        }

        // Confirmar que la categoría fue encontrada y obtener su ID
        \Log::info('Categoría encontrada:', ['categoria_id' => $categoria->id]);

        // Crear la incapacidad
        $incapacidadData = [
            'uuid' => (string) Str::orderedUuid(),
            'user_id' => $request->user_id,
            'tipo_incapacidad_reportada' => $request->tipoincapacidadreportada,
            'dias_incapacidad' => $request->diasIncapacidad,
            'fecha_inicio_incapacidad' => $request->fechaInicioIncapacidad,
            'aplica_cobro' => $request->aplica_cobro,
            'identificador_incapacidad'=>$request->identificador_incapacidad,
            'entidad_afiliada' => $request->entidadAfiliada,
            'categoria_id' => $categoria->id,  // Asignar el ID de la categoría encontrada
            'tipo_incapacidad' => $request->tipo_incapacidad,
        ];

        // Depuración: Verificar los datos de la incapacidad antes de crearla
        \Log::info('Datos de incapacidad a crear:', ['incapacidadData' => $incapacidadData]);

        $incapacidad = Incapacidades::create($incapacidadData);

        // Depuración: Verificar los datos de la incapacidad creada
        \Log::info('Incapacidad creada:', ['incapacidad' => $incapacidad]);

        // Manejar las imágenes si las hay
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Guarda la imagen usando su nombre original
                $path = $image->storeAs('incapacidad_images', $image->getClientOriginalName(), 'public');
                $incapacidad->images()->create(['image_path' => $path]);
            }
        }

        // Manejar los documentos si los hay
        if ($request->hasFile('documentos')) {
            foreach ($request->file('documentos') as $documento) {
                // Guarda el documento usando su nombre original
                $path = $documento->storeAs('incapacidad_documentos', $documento->getClientOriginalName(), 'public');
                $incapacidad->documentos()->create(['documentos' => $path]);
            }
        }

        // Responder con éxito
        return response(['message' => 'Incapacidad creada exitosamente'], 201);

    } catch (Exception $e) {
        // Mostrar el error y la traza del error
        return response(['message' => 'error', 'error' => $e->getMessage(), 'trace' => $e->getTrace()], 500);
    }
}




public function downloadDocument($id)
{
    try {
        // Buscar la incapacidad por su ID
        $incapacidad = Incapacidades::with('documentos')->findOrFail($id);
        
        // Crear un nuevo archivo ZIP
        $zip = new \ZipArchive();
        $zipFileName = storage_path("app/public/incapacidad_folder/{$incapacidad->id}/documentos_incapacidad_{$id}.zip");

        // Asegurarse de que el directorio existe
        $zipDir = dirname($zipFileName);
        if (!file_exists($zipDir)) {
            mkdir($zipDir, 0755, true);
        }

        if ($zip->open($zipFileName, \ZipArchive::CREATE) === TRUE) {
            // Verificar si hay documentos asociados
            if ($incapacidad->documentos->isEmpty()) {
                // Opción 1: Dejar el ZIP vacío y cerrarlo
                $zip->close();
                return response()->json(['message' => 'No hay documentos disponibles'], 200);
            }

            // Si hay documentos, agregarlos al ZIP
            foreach ($incapacidad->documentos as $documento) {
                $filePath = storage_path("app/public/{$documento->documentos}");
                if (file_exists($filePath)) {
                    // Usa el nombre original del archivo al añadir al ZIP
                    $zip->addFile($filePath, basename($filePath));
                } else {
                    \Log::error("File not found: $filePath");
                }
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'No se pudo crear el archivo ZIP'], 500);
        }

        // Descarga el archivo ZIP
        return response()->download($zipFileName)->deleteFileAfterSend(true);
    } catch (\Exception $e) {
        \Log::error('Error al descargar los documentos: ' . $e->getMessage());
        return response()->json(['error' => 'Error al descargar los documentos'], 500);
    }
}


public function update(Request $request, $id)
{
    $incapacidad = Incapacidades::find($id);
    if(!$incapacidad) {
        return response()->json(['message' => 'Incapacidad no encontrada'], 404);
    }
    

    // Solo actualiza los campos específicos si están presentes en la solicitud
    if($request->has('identificador_incapacidad')){
        $incapacidad->identificador_incapacidad = $request->identificador_incapacidad;
    }

    if ($request->has('aplica_cobro')) {
        $incapacidad->aplica_cobro = $request->aplica_cobro;
    }
    if ($request->has('tipo_incapacidad')) {
        $incapacidad->tipo_incapacidad = $request->tipo_incapacidad;
    }
    
    // Guarda los cambios en la base de datos
    $incapacidad->save();
    
    return response()->json($incapacidad);
}


public function downloadImages($id)
{
    try {
        // Buscar las imágenes asociadas a la incapacidad especificada
        $images = IncapacidadImage::where('incapacidades_id', $id)->get();

        // Crear un nuevo archivo ZIP
        $zip = new \ZipArchive();
        $zipFileName = storage_path("app/public/incapacidad_folder/{$id}/imagenes_incapacidad_{$id}.zip");

        // Asegurarse de que el directorio existe
        $zipDir = dirname($zipFileName);
        if (!file_exists($zipDir)) {
            mkdir($zipDir, 0755, true);
        }

        if ($zip->open($zipFileName, \ZipArchive::CREATE) === TRUE) {
            // Verificar si hay imágenes asociadas
            if ($images->isEmpty()) {
                $zip->close();
                return response()->json(['message' => 'No hay imágenes disponibles'], 200);
            }

            // Si hay imágenes, agregarlas al ZIP
            foreach ($images as $image) {
                $filePath = storage_path("app/public/{$image->image_path}");
                if (file_exists($filePath)) {
                    // Usa el nombre original del archivo al añadir al ZIP
                    $zip->addFile($filePath, basename($filePath));
                } else {
                    \Log::error("File not found: $filePath");
                }
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'No se pudo crear el archivo ZIP'], 500);
        }

        // Descarga el archivo ZIP
        return response()->download($zipFileName)->deleteFileAfterSend(true);
    } catch (\Exception $e) {
        \Log::error('Error al descargar las imágenes: ' . $e->getMessage());
        return response()->json(['error' => 'Error al descargar las imágenes'], 500);
    }
}


    
    public function destroy($id)
    {
        $incapacidad = Incapacidades::find($id);
        $incapacidad->delete();

        return response()->json(null, 204);
    }
    

}



