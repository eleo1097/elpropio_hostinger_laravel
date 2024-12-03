<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
            'ID', 
            'Nombre',
             'Cedula', 
             'Email',
             '',
              'Rol ID', 
              'Activado/Desactivado', 
              'Punto de Venta','Cargo',
              'Fecha de Creación',
               'Fecha de Actualización'
        ];
    }
}