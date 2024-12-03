<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserImportController extends Controller
{
    /**
     * Importa usuarios desde un archivo Excel.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        // Valida el archivo
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        // Procesa el archivo
        Excel::import(new UsersImport, $request->file('file'));

        // Devuelve una respuesta
        return response()->json([
            'message' => 'Usuarios importados exitosamente.'
        ]);
    }
}
