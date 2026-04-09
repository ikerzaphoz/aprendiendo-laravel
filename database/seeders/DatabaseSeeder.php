<?php

// ============================================================
// SEEDER PRINCIPAL — database/seeders/DatabaseSeeder.php
// ============================================================
// Este es el seeder "orquestador". Llama a todos los demás seeders.
// Cuando ejecutas "php artisan db:seed", Laravel ejecuta este archivo.
// ============================================================

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Llamamos al seeder de productos
        // Si tuvieras más tablas, añadirías sus seeders aquí:
        $this->call([
            ProductoSeeder::class,
            // UsuarioSeeder::class,
            // CategoriaSeeder::class,
        ]);
    }
}
