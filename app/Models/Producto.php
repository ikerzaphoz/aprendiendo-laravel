<?php

// ============================================================
// MODELO — app/Models/Producto.php
// ============================================================
// Un Modelo representa UNA TABLA de tu base de datos.
// Cada instancia del modelo = una fila de la tabla.
//
// EN PHP NATIVO escribías queries PDO directamente:
//   $stmt = $pdo->prepare('SELECT * FROM productos WHERE id = ?');
//   $stmt->execute([$id]);
//   $producto = $stmt->fetch(PDO::FETCH_ASSOC);
//
// EN LARAVEL usas el Modelo y Eloquent hace el SQL por ti:
//   $producto = Producto::find($id);
//   // Eso es todo. Eloquent hace el SELECT automáticamente.
// ============================================================

namespace App\Models;

// Importamos la clase base de Eloquent.
// Todos los modelos deben extender de esta clase.
use Illuminate\Database\Eloquent\Model;

// Factory para generar datos de prueba (lo usaremos en el Seeder)
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    // HasFactory nos permite crear datos de prueba con:
    // Producto::factory()->create()
    use HasFactory;

    // --------------------------------------------------------
    // NOMBRE DE LA TABLA
    // --------------------------------------------------------
    // Por convención, Laravel asume que si el modelo se llama
    // "Producto" (singular), la tabla se llama "productos" (plural).
    // Si tu tabla tiene otro nombre, lo especificas aquí:
    //
    // protected $table = 'mis_productos';
    //
    // Como nuestra tabla SÍ se llama "productos", no necesitamos
    // declarar $table. Laravel lo deduce solo.

    // --------------------------------------------------------
    // CAMPOS PERMITIDOS (fillable)
    // --------------------------------------------------------
    // Lista de columnas que se pueden asignar de forma masiva.
    // Esto es una medida de seguridad: evita que alguien envíe
    // campos extra por POST y los guarde en la BD sin querer.
    //
    // EN PHP NATIVO esto era tu responsabilidad manual:
    //   $nombre = $_POST['nombre'] ?? '';  // Solo cogías lo que querías
    //
    // EN LARAVEL declaras aquí los campos seguros y luego puedes hacer:
    //   Producto::create($request->all()); // Solo guarda los de $fillable
    protected $fillable = [
        'nombre',       // VARCHAR - nombre del producto
        'descripcion',  // TEXT - descripción larga
        'precio',       // DECIMAL - precio con decimales
        'stock',        // INTEGER - unidades disponibles
        'activo',       // BOOLEAN - si está visible o no
    ];

    // --------------------------------------------------------
    // CASTINGS (conversión automática de tipos)
    // --------------------------------------------------------
    // Laravel puede convertir automáticamente los valores de la BD
    // al tipo PHP correcto cuando los lees.
    //
    // Ejemplo: La BD guarda "1"/"0" para booleanos, pero con el cast
    // Laravel te devuelve true/false directamente.
    protected $casts = [
        'precio' => 'decimal:2', // Siempre 2 decimales: 9.99
        'stock'  => 'integer',   // Siempre entero
        'activo' => 'boolean',   // true/false en vez de 1/0
    ];

    // --------------------------------------------------------
    // CAMPOS OCULTOS (hidden)
    // --------------------------------------------------------
    // Campos que NO se incluirán cuando conviertas el modelo a JSON.
    // Útil para contraseñas, tokens internos, etc.
    //
    // protected $hidden = ['password', 'token_interno'];

    // --------------------------------------------------------
    // RELACIONES CON OTRAS TABLAS
    // --------------------------------------------------------
    // Aquí defines las relaciones entre tablas.
    // En PHP nativo hacías JOINs en SQL. En Eloquent defines métodos.
    //
    // Ejemplo: Si Producto pertenece a una Categoría:
    // public function categoria()
    // {
    //     return $this->belongsTo(Categoria::class);
    //     // Equivale a: SELECT * FROM categorias WHERE id = productos.categoria_id
    // }
    //
    // Ejemplo: Si un Producto tiene muchas Imágenes:
    // public function imagenes()
    // {
    //     return $this->hasMany(Imagen::class);
    //     // Equivale a: SELECT * FROM imagenes WHERE producto_id = ?
    // }

    // --------------------------------------------------------
    // MÉTODOS PERSONALIZADOS (lógica de negocio)
    // --------------------------------------------------------
    // Puedes añadir métodos que encapsulen lógica del producto.

    /**
     * Devuelve el precio formateado con símbolo de euro.
     * Uso en Blade: {{ $producto->precioFormateado() }}
     */
    public function precioFormateado(): string
    {
        return number_format($this->precio, 2, ',', '.') . ' €';
    }

    /**
     * Scope: Filtros reutilizables para queries.
     * Un "scope" es como un WHERE que puedes reutilizar.
     *
     * En PHP nativo repetías: WHERE activo = 1 en cada query.
     * Con scopes lo defines una vez y lo reutilizas así:
     *   Producto::activos()->get()
     */
    public function scopeActivos($query)
    {
        // Añade WHERE activo = 1 al query automáticamente
        return $query->where('activo', true);
    }

    /**
     * Scope para productos con stock disponible.
     * Uso: Producto::conStock()->get()
     */
    public function scopeConStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
