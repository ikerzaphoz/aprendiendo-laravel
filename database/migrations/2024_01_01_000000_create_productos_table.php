<?php

// ============================================================
// MIGRACIÓN — database/migrations/2024_01_01_000000_create_productos_table.php
// ============================================================
// Una migración es un script PHP que crea o modifica tablas en tu BD.
// Es como un "control de versiones" de tu base de datos.
//
// EN PHP NATIVO ejecutabas SQL a mano en phpMyAdmin:
//   CREATE TABLE productos (id INT AUTO_INCREMENT PRIMARY KEY, ...);
//
// EN LARAVEL defines la tabla con código PHP y ejecutas:
//   php artisan migrate
//
// Ventajas de las migraciones:
//   ✓ Control de versiones de la BD en Git
//   ✓ Todos los desarrolladores tienen la misma estructura
//   ✓ Puedes deshacer cambios con: php artisan migrate:rollback
//   ✓ Sabes exactamente qué cambios se han hecho y cuándo
//
// Para crear una migración nueva:
//   php artisan make:migration create_productos_table
// ============================================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// "return new class" es la forma moderna de Laravel 9+.
// Antes era "class CreateProductosTable extends Migration"
return new class extends Migration
{
    // --------------------------------------------------------
    // UP: Se ejecuta con "php artisan migrate"
    // Aquí CREAS o MODIFICAS la tabla
    // --------------------------------------------------------
    public function up(): void
    {
        // Schema::create('nombre_tabla', function(Blueprint $table) {...})
        // Equivale a: CREATE TABLE productos (...)
        Schema::create('productos', function (Blueprint $table) {

            // ── COLUMNAS AUTOMÁTICAS ────────────────────────
            // $table->id() crea: id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            // En PHP nativo: id INT AUTO_INCREMENT PRIMARY KEY
            $table->id();

            // ── TUS COLUMNAS ───────────────────────────────
            // $table->string('columna') → VARCHAR(255) NOT NULL
            $table->string('nombre');

            // ->nullable() permite NULL (columna opcional)
            // En PHP nativo: TEXT NULL
            $table->text('descripcion')->nullable();

            // decimal(total_dígitos, decimales)
            // En PHP nativo: DECIMAL(10, 2) NOT NULL
            $table->decimal('precio', 10, 2);

            // En PHP nativo: INT NOT NULL DEFAULT 0
            $table->integer('stock')->default(0);

            // boolean → TINYINT(1) en MySQL
            // true/false en PHP = 1/0 en la BD
            $table->boolean('activo')->default(true);

            // ── COLUMNAS AUTOMÁTICAS DE TIEMPO ─────────────
            // $table->timestamps() crea DOS columnas automáticamente:
            //   created_at  TIMESTAMP NULL  (se rellena al crear)
            //   updated_at  TIMESTAMP NULL  (se actualiza al modificar)
            //
            // Laravel las gestiona solo. No tienes que hacer nada.
            // En PHP nativo: TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE...
            $table->timestamps();

            // ── ÍNDICES (opcionales pero mejoran rendimiento) ──
            // Para búsquedas frecuentes por nombre
            $table->index('nombre');

            // Para filtrar por activo frecuentemente
            $table->index('activo');
        });
    }

    // --------------------------------------------------------
    // DOWN: Se ejecuta con "php artisan migrate:rollback"
    // Aquí DESHACES lo que hiciste en up()
    // Es como un "ctrl+z" para la base de datos
    // --------------------------------------------------------
    public function down(): void
    {
        // Elimina la tabla si existe
        // En PHP nativo: DROP TABLE IF EXISTS productos;
        Schema::dropIfExists('productos');
    }
};
