<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Empleado;
use App\Models\Remitente;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        Empleado::create([
            'emple_doc' => 1001,
            'emple_nombres' => 'Kevin',
            'emple_apellidos' => 'Villafrade',
            'password' => Hash::make('1234'),
            'emple_rol' => 1
        ]);

        Empleado::create([
            'emple_doc' => 1002,
            'emple_nombres' => 'Luis',
            'emple_apellidos' => 'Gomez',
            'password' => Hash::make('1234'),
            'emple_rol' => 2
        ]);

                Empleado::create([
            'emple_doc' => 1003,
            'emple_nombres' => 'Yuber',
            'emple_apellidos' => 'Paez',
            'password' => Hash::make('1234'),
            'emple_rol' => 3
        ]);
    }
}
