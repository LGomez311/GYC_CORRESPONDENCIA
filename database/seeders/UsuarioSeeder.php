<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Empleado;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        Empleado::updateOrCreate(
            ['emple_doc' => 1001],
            [
                'emple_nombres' => 'Kevin',
                'emple_apellidos' => 'Villafrade',
                'emple_correo' => 'kevin@gmail.com',
                'password' => Hash::make('1234'),
                'emple_rol' => 1,
                'emple_estado' => 1
            ]
        );

        Empleado::updateOrCreate(
            ['emple_doc' => 1002],
            [
                'emple_nombres' => 'Luis',
                'emple_apellidos' => 'Gomez',
                'emple_correo' => 'luis@gmail.com',
                'password' => Hash::make('1234'),
                'emple_rol' => 2,
                'emple_estado' => 1
            ]
        );

        Empleado::updateOrCreate(
            ['emple_doc' => 1003],
            [
                'emple_nombres' => 'Yuber',
                'emple_apellidos' => 'Paez',
                'emple_correo' => 'yuber@gmail.com',
                'password' => Hash::make('1234'),
                'emple_rol' => 3,
                'emple_estado' => 1
            ]
        );
    }
}
