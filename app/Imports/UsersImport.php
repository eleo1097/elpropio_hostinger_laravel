<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * Convierte cada fila del Excel a un modelo de usuario.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'cedula' => $row['cedula'],
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']), // Aquí encriptas la contraseña
            'is_active' => $row['is_active'] === 'Activo' ? true : false, // Convierte la cadena a booleano
            'rol_id' => 2, // Asigna un rol predeterminado, puedes modificar esto según sea necesario
            'p_venta' =>$row['p_venta'], 
            'cargo' =>$row['cargo'],
        ]);
    }
}
