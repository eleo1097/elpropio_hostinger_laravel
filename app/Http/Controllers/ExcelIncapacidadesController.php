<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncapacidadesExport;

class ExcelIncapacidadesController extends Controller
{
    public function exportIncapacidades(Request $request)
    {
        $year = $request->query('year');

        // Si se proporciona un año, descargar las incapacidades solo para ese año
        if ($year) {
            return Excel::download(new IncapacidadesExport($year), 'Incapacidades_'.$year.'.xlsx');
        } else {
            // Si no se proporciona un año, descargar todas las incapacidades
            return Excel::download(new IncapacidadesExport, 'Incapacidades.xlsx');
        }
    }
}
