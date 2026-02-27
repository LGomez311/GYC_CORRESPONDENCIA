<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RemitenteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('remitente')->insert([
            [
                'rem_doc' => 1004,
                'nit_empresa' => '3241234', // ya existe en empresa
                'rem_nombres' => 'Kevin',
                'rem_apellidos' => 'Daniel',
                'rem_correo' => 'kevin.daniel@gmail.com',
                'password' => Hash::make('1234'),
                'rem_tel' => '3001234567',
                'rem_ciudad' => '11001', // Bogotá
                'rem_estado' => 1 // 1 = Activo según tu tabla estado
            ]
        ]);
    }
}
