<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Empleado;
use App\Models\Remitente;
use App\Models\Empresa;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Password común para todos los perfiles
        $commonPassword = Hash::make('SuperAdmin123!');
        
        // Obtener la primera empresa disponible para asociar los registros
        $empresa = Empresa::first();
        $nitEmpresa = $empresa ? $empresa->nit_empresa : '1234567890';

        // Obtener la primera área disponible
        $area = \App\Models\Area::first();
        $idArea = $area ? $area->id_area : 1;

        // 1. Super Administrador (Rol ID 1)
        Empleado::updateOrCreate(
            ['emple_doc' => '999001'],
            [
                'nit_empresa' => $nitEmpresa,
                'emple_nombres' => 'Super Admin',
                'emple_apellidos' => 'SAdmin',
                'emple_tel' => '3009990001',
                'emple_correo' => 'superadmin.sadmin@gmail.com',
                'password' => $commonPassword,
                'emple_rol' => 1,
                'emple_estado' => 1,
                'emple_area' => $idArea,
            ]
        );

        // 2. Administrador (Rol ID 2)
        Empleado::updateOrCreate(
            ['emple_doc' => '999002'],
            [
                'nit_empresa' => $nitEmpresa,
                'emple_nombres' => 'Super Admin',
                'emple_apellidos' => 'Admin',
                'emple_tel' => '3009990002',
                'emple_correo' => 'superadmin.admin@gmail.com',
                'password' => $commonPassword,
                'emple_rol' => 2,
                'emple_estado' => 1,
                'emple_area' => $idArea,
            ]
        );

        // 3. Empleado / Usuario Estandar (Rol ID 3)
        Empleado::updateOrCreate(
            ['emple_doc' => '999003'],
            [
                'nit_empresa' => $nitEmpresa,
                'emple_nombres' => 'Super Admin',
                'emple_apellidos' => 'Empleado',
                'emple_tel' => '3009990003',
                'emple_correo' => 'superadmin.empleado@gmail.com',
                'password' => $commonPassword,
                'emple_rol' => 3,
                'emple_estado' => 1,
                'emple_area' => $idArea,
            ]
        );

        // 4. Remitente
        Remitente::updateOrCreate(
            ['rem_doc' => '999004'],
            [
                'nit_empresa' => $nitEmpresa,
                'rem_nombres' => 'Super Admin',
                'rem_apellidos' => 'Remitente',
                'rem_correo' => 'superadmin.remitente@gmail.com',
                'password' => $commonPassword,
                'rem_tel' => '3000000000',
                'rem_ciudad' => '11001', // Bogotá por defecto
                'rem_estado' => 1,
            ]
        );
    }
}
