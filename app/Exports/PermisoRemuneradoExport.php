<?php

namespace App\Exports;

use App\Models\PermisoRemunerado;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PermisoRemuneradoExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Obtener los permisos remunerados con los datos necesarios
        return PermisoRemunerado::with(['user:id,name,cedula'])->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID', 
            'Usuario', 
            'Cédula', 
            'P. Venta', 
            'Categoría Solicitud', 
            'Tiempo Requerido', 
            'Unidad de Tiempo', 
            'Hora', 
            'Fecha de Permiso', 
            'Fecha de Solicitud', 
            'Justificación', 
            'Estado'
        ];
    }

    /**
     * Map the row data to the appropriate columns in the export.
     *
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->user->name,
            $row->user->cedula,
            $row->p_venta,
            $row->categoria_solicitud,
            $row->tiempo_requerido,
            $row->unidad_tiempo,
            $row->hora,
            $row->fecha_permiso,
            $row->fecha_solicitud,
            $row->justificacion,
            $row->estado
        ];
    }
}
