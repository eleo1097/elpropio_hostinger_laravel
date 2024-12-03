<?php
namespace App\Imports;

use App\Models\Horario;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;

class HorariosImport implements ToCollection, WithChunkReading
{
    public function collection(Collection $rows)
    {
        // Saltar las dos primeras filas
        foreach ($rows->slice(1) as $row) {
            Horario::create([
                'cedula' => $row[0],
                'lunes' => $row[1],
                'martes' => $row[2],
                'miercoles' => $row[3],
                'jueves' => $row[4],
                'viernes' => $row[5],
                'sabado' => $row[6],
                'domingo' => $row[7],

                'lunes2' => $row[8],
                'martes2' => $row[9],
                'miercoles2' => $row[10],
                'jueves2' => $row[11],
                'viernes2' => $row[12],
                'sabado2' => $row[13],
                'domingo2' => $row[14],
            ]);
        }
    }

    public function chunkSize(): int
    {
        return 100; // Ajusta según lo necesites
    }
}
