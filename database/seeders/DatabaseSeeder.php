<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UsuarioSeeder;
use Database\Seeders\RemitenteSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamar a todos los seeders que tengas
        $this->call([
            UsuarioSeeder::class,
            RemitenteSeeder::class,
        ]);
    }
}
