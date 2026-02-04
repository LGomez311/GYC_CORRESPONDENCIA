<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estado;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estado::insert([
            [
                'id_estado'   => 1,
                'estado_nomb' => 'Activo',
            ],
            [
                'id_estado'   => 2,
                'estado_nomb' => 'Inactivo',
            ],
        ]);
    }
}
