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
            ['emple_doc' => 1005912004],
            [
                'emple_nombres' => 'Kevin',
                'emple_apellidos' => 'Villafrade',
                'emple_correo' => 'kevindany2209@gmail.com',
                'password' => Hash::make('KevinVilla29@'),
                'emple_rol' => 1,
                'emple_estado' => 1
            ]
        );

        Empleado::updateOrCreate(
            ['emple_doc' => 2005914095],
            [
                'emple_nombres' => 'SUPER',
                'emple_apellidos' => 'ADMIN',
                'emple_correo' => 'kevinreal2209@gmail.com',
                'password' => Hash::make('KevinVilla29@'),
                'emple_rol' => 1,
                'emple_estado' => 1
            ]
        );

        Empleado::updateOrCreate(
            ['emple_doc' => 1106394865],
            [
                'emple_nombres' => 'Luis',
                'emple_apellidos' => 'Gomez',
                'emple_correo' => 'lucho3112007@gmail.com',
                'password' => Hash::make('Luisgomez11@'),
                'emple_rol' => 1,
                'emple_estado' => 1
            ]
        );

        Empleado::updateOrCreate(
            ['emple_doc' => 1070730214],
            [
                'emple_nombres' => 'Yuber',
                'emple_apellidos' => 'Paez',
                'emple_correo' => 'santiagopc333@gmail.com',
                'password' => Hash::make('Yuber1234!'),
                'emple_rol' => 1,
                'emple_estado' => 1
            ]
        );
    }
}
