<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario de prueba
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password')
            ]
        );

        // Ejecutar seeders
        $this->call([
            RemitenteSeeder::class,
            DepartamentoSeeder::class,
            CiudadSeeder::class,
        ]);
    }
}
