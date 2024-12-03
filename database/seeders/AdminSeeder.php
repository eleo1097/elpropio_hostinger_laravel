<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     public function run()
     {

        $user = User::create([
            'name' => "SuperAdmin",
            'cedula' => "1097092580", 
            'email' => "betsy.tboada@mxm.com.co",
            'password' => Hash::make('123456'),
            'rol_id' => 4,
            'p_venta' => "ADMINISTRACION",
            'cargo'=> "ANALISTA DE PROCESOS",

            'is_active' => true,

        ]);
        

        $user = User::create([
            'name' => "Administrador1",
            'cedula' => "1097092539",  // Agrega cedula 
            'email' => "talentohumanomxm1@gmail.com",
            'password' => Hash::make('123456'),
            'p_venta' => "ADMINISTRACION",
            'cargo'=> "ANALISTA DE PROCESOS",
            'rol_id' => 1,
            'is_active' => true,

        ]);

        $user = User::create([
            'name' => "Administrador2",
            'cedula' => "27951191", 
            'email' => "talentohumanomxm2@gmail.com",
            'password' => Hash::make('123456'),
            'p_venta' => "ADMINISTRACION",
            'cargo'=> "ANALISTA DE PROCESOS",
            'rol_id' => 1,
            'is_active' => true,

        ]);

        $user = User::create([
            'name' => "Administrador3",
            'cedula' => "27951193", 
            'email' => "talentohumanomxm3@gmail.com",
            'password' => Hash::make('123456'),
            'p_venta' => "ADMINISTRACION",
            'cargo'=> "ANALISTA DE PROCESOS",
            'rol_id' => 1,
            'is_active' => true,

        ]);

        $user = User::create([
            'name' => "Comunicacion.MXM",
            'cedula' => "1097092588", 
            'email' => "comunicacion@gmail.com",
            'password' => Hash::make('123456'),
            'p_venta' => "ADMINISTRACION",
            'cargo'=> "ANALISTA DE PROCESOS",
            'rol_id' => 3,
            'is_active' => true,

        ]);
        
       
     }
}
