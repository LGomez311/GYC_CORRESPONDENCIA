<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CiudadSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ciudad')->insert([
            ['ciudad_cod_post' => '05001', 'ciudad_nom' => 'Medellín', 'ciudad_id_dpto' => '05'],
            ['ciudad_cod_post' => '08001', 'ciudad_nom' => 'Barranquilla', 'ciudad_id_dpto' => '08'],
            ['ciudad_cod_post' => '11001', 'ciudad_nom' => 'Bogotá D.C.', 'ciudad_id_dpto' => '11'],
            ['ciudad_cod_post' => '13001', 'ciudad_nom' => 'Cartagena', 'ciudad_id_dpto' => '13'],
            ['ciudad_cod_post' => '15001', 'ciudad_nom' => 'Tunja', 'ciudad_id_dpto' => '15'],
            ['ciudad_cod_post' => '17001', 'ciudad_nom' => 'Manizales', 'ciudad_id_dpto' => '17'],
            ['ciudad_cod_post' => '18001', 'ciudad_nom' => 'Florencia', 'ciudad_id_dpto' => '18'],
            ['ciudad_cod_post' => '19001', 'ciudad_nom' => 'Popayán', 'ciudad_id_dpto' => '19'],
            ['ciudad_cod_post' => '20001', 'ciudad_nom' => 'Valledupar', 'ciudad_id_dpto' => '20'],
            ['ciudad_cod_post' => '23001', 'ciudad_nom' => 'Montería', 'ciudad_id_dpto' => '23'],
            ['ciudad_cod_post' => '25001', 'ciudad_nom' => 'Bogotá D.C.', 'ciudad_id_dpto' => '25'],
            ['ciudad_cod_post' => '27001', 'ciudad_nom' => 'Quibdó', 'ciudad_id_dpto' => '27'],
            ['ciudad_cod_post' => '41001', 'ciudad_nom' => 'Neiva', 'ciudad_id_dpto' => '41'],
            ['ciudad_cod_post' => '44001', 'ciudad_nom' => 'Riohacha', 'ciudad_id_dpto' => '44'],
            ['ciudad_cod_post' => '47001', 'ciudad_nom' => 'Santa Marta', 'ciudad_id_dpto' => '47'],
            ['ciudad_cod_post' => '50001', 'ciudad_nom' => 'Villavicencio', 'ciudad_id_dpto' => '50'],
            ['ciudad_cod_post' => '52001', 'ciudad_nom' => 'Pasto', 'ciudad_id_dpto' => '52'],
            ['ciudad_cod_post' => '54001', 'ciudad_nom' => 'Cúcuta', 'ciudad_id_dpto' => '54'],
            ['ciudad_cod_post' => '63001', 'ciudad_nom' => 'Armenia', 'ciudad_id_dpto' => '63'],
            ['ciudad_cod_post' => '66001', 'ciudad_nom' => 'Pereira', 'ciudad_id_dpto' => '66'],
            ['ciudad_cod_post' => '68001', 'ciudad_nom' => 'Bucaramanga', 'ciudad_id_dpto' => '68'],
            ['ciudad_cod_post' => '70001', 'ciudad_nom' => 'Sincelejo', 'ciudad_id_dpto' => '70'],
            ['ciudad_cod_post' => '73001', 'ciudad_nom' => 'Ibagué', 'ciudad_id_dpto' => '73'],
            ['ciudad_cod_post' => '76001', 'ciudad_nom' => 'Cali', 'ciudad_id_dpto' => '76'],
            ['ciudad_cod_post' => '81001', 'ciudad_nom' => 'Arauca', 'ciudad_id_dpto' => '81'],
            ['ciudad_cod_post' => '85001', 'ciudad_nom' => 'Yopal', 'ciudad_id_dpto' => '85'],
            ['ciudad_cod_post' => '86001', 'ciudad_nom' => 'Mocoa', 'ciudad_id_dpto' => '86'],
            ['ciudad_cod_post' => '88001', 'ciudad_nom' => 'San Andrés', 'ciudad_id_dpto' => '88'],
            ['ciudad_cod_post' => '91001', 'ciudad_nom' => 'Leticia', 'ciudad_id_dpto' => '91'],
            ['ciudad_cod_post' => '94001', 'ciudad_nom' => 'Inírida', 'ciudad_id_dpto' => '94'],
            ['ciudad_cod_post' => '95001', 'ciudad_nom' => 'San José del Guaviare', 'ciudad_id_dpto' => '95'],
            ['ciudad_cod_post' => '97001', 'ciudad_nom' => 'Mitú', 'ciudad_id_dpto' => '97'],
            ['ciudad_cod_post' => '99001', 'ciudad_nom' => 'Puerto Carreño', 'ciudad_id_dpto' => '99'],
        ]);
    }
}