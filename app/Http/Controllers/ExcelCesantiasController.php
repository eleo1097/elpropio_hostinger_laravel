<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CesantiasExport;

class ExcelCesantiasController extends Controller
{
    public function exportCesantias($year)
    {
        return Excel::download(new CesantiasExport($year), 'cesantias_' . $year . '.xlsx');
    }
}

