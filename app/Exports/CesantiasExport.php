<?php
namespace App\Exports;

use App\Models\Cesantias;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CesantiasExport implements FromCollection, WithHeadings, WithMapping
{
    protected $year;

    public function __construct(int $year)
    {
        $this->year = $year;
    }

    public function collection()
    {
        return Cesantias::whereYear('created_at', $this->year)->get();
    }

    public function headings(): array
    {
        return [
            'ID', 'Nombre', 'Cedula', 'Tipo de solicitud','estado',
        ];
    }

    public function map ($cesantias): array
    {
        return [
            $cesantias->id,
            $cesantias->user->name,
            $cesantias->user->cedula,
            $cesantias->tipo_cesantia_reportada,
            $cesantias->estado,
        ];
    }
}
