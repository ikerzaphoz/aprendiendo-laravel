<?php

// ============================================================
// SEEDER — database/seeders/ProductoSeeder.php
// ============================================================
// Un Seeder llena la base de datos con datos de prueba.
//
// EN PHP NATIVO hacías INSERTs manuales en phpMyAdmin o un .sql.
// EN LARAVEL defines los datos aquí y ejecutas:
//   php artisan db:seed
//   php artisan migrate:fresh --seed  (borra todo, migra y semilla)
//
// Para crear un seeder:
//   php artisan make:seeder ProductoSeeder
// ============================================================

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Ejecuta el seeder.
     * Crea productos de ejemplo para poder trabajar desde el primer momento.
     */
    public function run(): void
    {
        // Limpiamos la tabla antes de insertar (para evitar duplicados)
        // En PHP nativo: $pdo->exec('DELETE FROM productos');
        Producto::truncate();

        // Datos de ejemplo — array de arrays con los datos de cada producto
        $productos = [
            [
                'nombre'      => 'Laptop HP Pavilion 15',
                'descripcion' => 'Portátil con procesador Intel Core i5, 8GB RAM, 512GB SSD. Ideal para trabajo y estudio.',
                'precio'      => 699.99,
                'stock'       => 15,
                'activo'      => true,
            ],
            [
                'nombre'      => 'Ratón inalámbrico Logitech MX Master 3',
                'descripcion' => 'Ratón ergonómico con scroll electromagnético. Conectividad Bluetooth y Unifying.',
                'precio'      => 89.99,
                'stock'       => 42,
                'activo'      => true,
            ],
            [
                'nombre'      => 'Monitor Samsung 27" 4K',
                'descripcion' => 'Monitor UHD 4K con panel IPS, 60Hz, HDR10. Conexiones HDMI y DisplayPort.',
                'precio'      => 349.00,
                'stock'       => 8,
                'activo'      => true,
            ],
            [
                'nombre'      => 'Teclado mecánico Keychron K2',
                'descripcion' => 'Teclado mecánico compacto 75%, switches Red, retroiluminación RGB. Compatible Mac y Windows.',
                'precio'      => 79.00,
                'stock'       => 0,  // Sin stock
                'activo'      => true,
            ],
            [
                'nombre'      => 'Auriculares Sony WH-1000XM5',
                'descripcion' => 'Auriculares inalámbricos con cancelación de ruido líder en su clase. 30h de batería.',
                'precio'      => 349.99,
                'stock'       => 23,
                'activo'      => false,  // Desactivado (no visible)
            ],
        ];

        // Recorremos el array e insertamos cada producto
        // Producto::create() hace el INSERT respetando los $fillable del Modelo
        foreach ($productos as $datos) {
            Producto::create($datos);
        }

        // También puedes usar insert() para insertar todos de golpe (más rápido):
        // Producto::insert($productos);
        // Pero insert() no actualiza timestamps ni usa $fillable.

        // Informamos de cuántos productos se crearon (aparece en la terminal)
        $this->command->info('✅ ' . count($productos) . ' productos de ejemplo creados correctamente.');
    }
}
