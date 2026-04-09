<?php

// ============================================================
// CONTROLLER — app/Http/Controllers/ProductoController.php
// ============================================================
// El Controller contiene la LÓGICA de cada acción.
// Es el intermediario entre la ruta (URL) y la vista (HTML).
//
// EN PHP NATIVO tu lógica vivía dentro del propio archivo de la página:
//   // productos.php
//   $productos = $pdo->query('SELECT * FROM productos')->fetchAll();
//   include 'views/lista.php';
//
// EN LARAVEL la lógica va en métodos separados del Controller,
// y la vista es un archivo .blade.php independiente.
//
// Para crear este archivo automáticamente:
//   php artisan make:controller ProductoController --resource
// El flag --resource crea los 7 métodos CRUD de una vez.
// ============================================================

namespace App\Http\Controllers;

// Importamos el Modelo para poder usarlo
use App\Models\Producto;

// Request encapsula todo lo que el usuario envía:
// $_GET, $_POST, $_FILES, headers, etc.
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // --------------------------------------------------------
    // INDEX — Listar todos los productos
    // URL: GET /productos
    // --------------------------------------------------------
    /**
     * Muestra la lista de todos los productos.
     *
     * EN PHP NATIVO:
     *   $productos = $pdo->query('SELECT * FROM productos')->fetchAll();
     *   include 'views/productos_lista.php';
     *
     * EN LARAVEL:
     *   Eloquent construye el SQL, ejecuta y devuelve objetos PHP.
     */
    public function index()
    {
        // Producto::all() → SELECT * FROM productos
        // Pero mejor usamos paginate() para no cargar miles de filas:
        // Producto::paginate(10) → SELECT * FROM productos LIMIT 10 OFFSET 0
        //
        // También podemos encadenar condiciones:
        // Producto::where('activo', true)->orderBy('nombre')->paginate(10)
        $productos = Producto::orderBy('nombre')->paginate(10);

        // return view('nombre.de.vista', ['variable' => $datos])
        // Laravel busca el archivo: resources/views/productos/index.blade.php
        // El punto (.) es equivalente a la barra (/): productos/index
        return view('productos.index', [
            'productos' => $productos,
            // Pasamos variables adicionales que la vista puede necesitar
            'total' => Producto::count(),
        ]);

        // EQUIVALENTE ALTERNATIVO más corto (compact crea el array automáticamente):
        // return view('productos.index', compact('productos'));
    }

    // --------------------------------------------------------
    // CREATE — Mostrar formulario de creación
    // URL: GET /productos/create
    // --------------------------------------------------------
    /**
     * Muestra el formulario vacío para crear un producto nuevo.
     * Este método SOLO devuelve la vista con el formulario.
     * El guardado lo hace store().
     *
     * EN PHP NATIVO: include 'views/crear_producto.php';
     */
    public function create()
    {
        // No necesitamos datos de la BD, solo mostramos el formulario
        return view('productos.create');
    }

    // --------------------------------------------------------
    // STORE — Guardar el nuevo producto
    // URL: POST /productos
    // --------------------------------------------------------
    /**
     * Procesa el formulario de creación y guarda en la BD.
     *
     * EN PHP NATIVO:
     *   $nombre = $_POST['nombre'] ?? '';
     *   // validar manualmente...
     *   $stmt = $pdo->prepare('INSERT INTO productos (nombre, precio) VALUES (?, ?)');
     *   $stmt->execute([$nombre, $precio]);
     *   header('Location: /productos.php');
     *
     * @param Request $request  Laravel inyecta esto automáticamente
     */
    public function store(Request $request)
    {
        // ── PASO 1: VALIDACIÓN ──────────────────────────────
        // En PHP nativo hacías if/else a mano.
        // Laravel valida de una sola vez y devuelve al formulario
        // automáticamente si algo falla (con los errores disponibles en Blade).
        $datosValidados = $request->validate([
            // 'campo' => 'regla1|regla2|regla3'
            'nombre'      => 'required|string|max:255',
            // required: no puede estar vacío
            // string: debe ser texto
            // max:255: máximo 255 caracteres

            'descripcion' => 'nullable|string',
            // nullable: puede estar vacío

            'precio'      => 'required|numeric|min:0',
            // numeric: debe ser número
            // min:0: no puede ser negativo

            'stock'       => 'required|integer|min:0',
            // integer: debe ser número entero

            'activo'      => 'boolean',
            // boolean: true/false, 1/0
        ]);

        // ── PASO 2: GUARDAR EN BD ───────────────────────────
        // Producto::create() hace el INSERT automáticamente.
        // Solo guarda los campos definidos en $fillable del Modelo.
        //
        // EN PHP NATIVO:
        //   $stmt = $pdo->prepare('INSERT INTO productos ...');
        //   $stmt->execute([...]);
        Producto::create($datosValidados);

        // ── PASO 3: REDIRIGIR CON MENSAJE ──────────────────
        // redirect()->route('productos.index') va a /productos
        // ->with('exito', '...') guarda un mensaje en la sesión
        // que mostraremos en la vista con @session('exito')
        //
        // EN PHP NATIVO:
        //   $_SESSION['mensaje'] = 'Producto creado';
        //   header('Location: /productos.php'); exit;
        return redirect()
            ->route('productos.index')
            ->with('exito', 'Producto creado correctamente.');
    }

    // --------------------------------------------------------
    // SHOW — Ver detalle de un producto
    // URL: GET /productos/{id}
    // --------------------------------------------------------
    /**
     * Muestra los detalles de un producto específico.
     *
     * Laravel hace "Route Model Binding": detecta que el parámetro
     * se llama $producto (igual que el Modelo) y automáticamente
     * hace el SELECT y lanza 404 si no existe.
     *
     * EN PHP NATIVO:
     *   $id = $_GET['id'];
     *   $stmt = $pdo->prepare('SELECT * FROM productos WHERE id = ?');
     *   $stmt->execute([$id]);
     *   $producto = $stmt->fetch();
     *   if (!$producto) { die('No encontrado'); }
     *
     * EN LARAVEL (con Route Model Binding):
     *   Laravel lo hace todo. Solo recibes $producto ya listo.
     *
     * @param Producto $producto  Laravel inyecta el objeto automáticamente
     */
    public function show(Producto $producto)
    {
        // $producto ya está cargado de la BD. Sin queries extra.
        return view('productos.show', compact('producto'));
    }

    // --------------------------------------------------------
    // EDIT — Mostrar formulario de edición
    // URL: GET /productos/{id}/edit
    // --------------------------------------------------------
    /**
     * Muestra el formulario de edición con los datos actuales.
     * El guardado lo hace update().
     */
    public function edit(Producto $producto)
    {
        // Mismo Route Model Binding que en show()
        // Pasamos el producto a la vista para pre-rellenar el formulario
        return view('productos.edit', compact('producto'));
    }

    // --------------------------------------------------------
    // UPDATE — Guardar los cambios
    // URL: PUT /productos/{id}
    // --------------------------------------------------------
    /**
     * Procesa el formulario de edición y actualiza en la BD.
     *
     * EN PHP NATIVO:
     *   $stmt = $pdo->prepare('UPDATE productos SET nombre=?, precio=? WHERE id=?');
     *   $stmt->execute([$nombre, $precio, $id]);
     */
    public function update(Request $request, Producto $producto)
    {
        // Mismas reglas de validación que en store()
        $datosValidados = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'activo'      => 'boolean',
        ]);

        // $producto->update() hace el UPDATE automáticamente
        // UPDATE productos SET nombre=?, precio=?, ... WHERE id=?
        $producto->update($datosValidados);

        return redirect()
            ->route('productos.show', $producto)
            ->with('exito', 'Producto actualizado correctamente.');
    }

    // --------------------------------------------------------
    // DESTROY — Eliminar un producto
    // URL: DELETE /productos/{id}
    // --------------------------------------------------------
    /**
     * Elimina un producto de la BD.
     *
     * EN PHP NATIVO:
     *   $stmt = $pdo->prepare('DELETE FROM productos WHERE id = ?');
     *   $stmt->execute([$id]);
     *   header('Location: /productos.php'); exit;
     */
    public function destroy(Producto $producto)
    {
        // $producto->delete() hace el DELETE automáticamente
        // DELETE FROM productos WHERE id = ?
        $producto->delete();

        return redirect()
            ->route('productos.index')
            ->with('exito', 'Producto eliminado correctamente.');
    }
}
