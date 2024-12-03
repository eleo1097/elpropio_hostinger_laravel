<?php

namespace App\Http\Controllers;

use App\Imports\CategoriasImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaImportController extends Controller
{
    /**
     * Importar el archivo Excel con las categorías.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todas las categorías desde la base de datos
        $categorias = Categoria::all(['id', 'codigo']); // Suponiendo que tienes un campo 'codigo'

        return response()->json($categorias);
    }



    public function importar(Request $request)
    {
        // Validar que el archivo esté presente
        $request->validate([
            'archivo' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        // Procesar la importación del archivo Excel
        Excel::import(new CategoriasImport, $request->file('archivo'));

        return response()->json(['success' => 'Archivo importado con éxito.'], 200);
       
    }
}
