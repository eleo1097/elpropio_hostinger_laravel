<?php
namespace App\Exports;

use App\Models\Incapacidades;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IncapacidadesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $year;

    public function __construct($year)
    {
        $this->year = $year;
    }

    public function collection()
    {
        // Filtrar las incapacidades por año seleccionado
        return Incapacidades::with('user')
            ->whereYear('fecha_inicio_incapacidad', $this->year)
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID', 'Nombre del Usuario','Cedula', 'Dias de incapacidad', 'Fecha inicio incapacidad', 'Aplica cobro','identificador', 'Eps Afiliada','codigo', 'Tipo de incapacidad','tipo_incapacidad_reportada','Fecha de Creación', 'Fecha de Actualización'
        ];
    }

    public function map($incapacidad): array
{
    $aplicaCobro = $incapacidad->aplica_cobro !== null ? ($incapacidad->aplica_cobro ? 'Sí' : 'No') : '';

    return [
        $incapacidad->id,
        $incapacidad->user->name, // Acceder al nombre del usuario
        $incapacidad->user->cedula,
        $incapacidad->dias_incapacidad,
        $incapacidad->fecha_inicio_incapacidad,
        $aplicaCobro,
        $incapacidad->identificador_incapacidad,
        $incapacidad->entidad_afiliada,
        $incapacidad->categoria->codigo,
        $incapacidad->tipo_incapacidad,
        $incapacidad->tipo_incapacidad_reportada,
        $incapacidad->created_at,
        $incapacidad->updated_at,
    ];
}


}
