<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Obtener todas las categorías.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todas las categorías desde la base de datos
        $categorias = Categoria::all(['id', 'codigo']); // Se obtiene solo el id y el código

        return response()->json($categorias);
    }
}
