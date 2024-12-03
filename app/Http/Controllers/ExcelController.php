<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class ExcelController extends Controller
{
    public function exportUsers()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function headings(): array
    {
        return [
            'ID','Nombre','Cedula','Email','Rol ID','Fecha de Creación','Fecha de Actualización'
        ];
    }
}