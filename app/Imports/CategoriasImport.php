<?php

namespace App\Imports;

use App\Models\Categoria;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading; // Para mejorar el rendimiento con grandes archivos

class CategoriasImport implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
     * Convert each row into a Categoria model.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Categoria([
            'codigo' => $row['codigo'],
            'nombre' => $row['nombre'],
            'descripcion' => $row['descripcion'],
        ]);
    }

    /**
     * Define the chunk size for processing the file.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;  // Puedes ajustar el tamaño del "chunk" según el rendimiento
    }
}
