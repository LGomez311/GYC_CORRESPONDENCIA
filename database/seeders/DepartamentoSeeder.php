<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departamento')->insert([
            ['dpto_codigo_postal' => '05', 'dpto_nombre' => 'Antioquia'],
            ['dpto_codigo_postal' => '08', 'dpto_nombre' => 'Atlántico'],
            ['dpto_codigo_postal' => '11', 'dpto_nombre' => 'Bogotá D.C.'],
            ['dpto_codigo_postal' => '13', 'dpto_nombre' => 'Bolívar'],
            ['dpto_codigo_postal' => '15', 'dpto_nombre' => 'Boyacá'],
            ['dpto_codigo_postal' => '17', 'dpto_nombre' => 'Caldas'],
            ['dpto_codigo_postal' => '18', 'dpto_nombre' => 'Caquetá'],
            ['dpto_codigo_postal' => '19', 'dpto_nombre' => 'Cauca'],
            ['dpto_codigo_postal' => '20', 'dpto_nombre' => 'Cesar'],
            ['dpto_codigo_postal' => '23', 'dpto_nombre' => 'Córdoba'],
            ['dpto_codigo_postal' => '25', 'dpto_nombre' => 'Cundinamarca'],
            ['dpto_codigo_postal' => '27', 'dpto_nombre' => 'Chocó'],
            ['dpto_codigo_postal' => '41', 'dpto_nombre' => 'Huila'],
            ['dpto_codigo_postal' => '44', 'dpto_nombre' => 'La Guajira'],
            ['dpto_codigo_postal' => '47', 'dpto_nombre' => 'Magdalena'],
            ['dpto_codigo_postal' => '50', 'dpto_nombre' => 'Meta'],
            ['dpto_codigo_postal' => '52', 'dpto_nombre' => 'Nariño'],
            ['dpto_codigo_postal' => '54', 'dpto_nombre' => 'Norte de Santander'],
            ['dpto_codigo_postal' => '63', 'dpto_nombre' => 'Quindío'],
            ['dpto_codigo_postal' => '66', 'dpto_nombre' => 'Risaralda'],
            ['dpto_codigo_postal' => '68', 'dpto_nombre' => 'Santander'],
            ['dpto_codigo_postal' => '70', 'dpto_nombre' => 'Sucre'],
            ['dpto_codigo_postal' => '73', 'dpto_nombre' => 'Tolima'],
            ['dpto_codigo_postal' => '76', 'dpto_nombre' => 'Valle del Cauca'],
            ['dpto_codigo_postal' => '766', 'dpto_nombre' => 'Dsds'],
            ['dpto_codigo_postal' => '81', 'dpto_nombre' => 'Arauca'],
            ['dpto_codigo_postal' => '85', 'dpto_nombre' => 'Casanare'],
            ['dpto_codigo_postal' => '86', 'dpto_nombre' => 'Putumayo'],
            ['dpto_codigo_postal' => '88', 'dpto_nombre' => 'San Andrés y Providencia'],
            ['dpto_codigo_postal' => '91', 'dpto_nombre' => 'Amazonas'],
            ['dpto_codigo_postal' => '94', 'dpto_nombre' => 'Guainía'],
            ['dpto_codigo_postal' => '95', 'dpto_nombre' => 'Guaviare'],
            ['dpto_codigo_postal' => '97', 'dpto_nombre' => 'Vaupés'],
            ['dpto_codigo_postal' => '99', 'dpto_nombre' => 'Vichada'],
        ]);
    }
}
