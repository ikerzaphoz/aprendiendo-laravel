<?php

// ============================================================
// ARCHIVO DE RUTAS — routes/web.php
// ============================================================
// Este es el "router" de tu aplicación. Aquí defines qué URL
// lleva a qué función del Controller.
//
// EN PHP NATIVO hacías algo así:
//   $page = $_GET['page'] ?? 'home';
//   if ($page === 'productos') { include 'productos.php'; }
//   elseif ($page === 'crear') { include 'crear.php'; }
//   ...
//
// EN LARAVEL tienes este archivo limpio y organizado.
// ============================================================

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

// ============================================================
// RUTA DE INICIO
// ============================================================
// Cuando el usuario visita "/" redirige a "/productos"
// Route::redirect es un atajo para redirecciones simples.
// En PHP nativo: header('Location: /productos.php'); exit;
Route::redirect('/', '/productos');

// ============================================================
// RUTAS DE PRODUCTOS — CRUD COMPLETO
// ============================================================
// En vez de definir 7 rutas a mano, Route::resource las crea todas.
//
// Esta única línea crea automáticamente:
//
//   GET    /productos           → ProductoController@index   (listar)
//   GET    /productos/create    → ProductoController@create  (formulario crear)
//   POST   /productos           → ProductoController@store   (guardar nuevo)
//   GET    /productos/{id}      → ProductoController@show    (ver uno)
//   GET    /productos/{id}/edit → ProductoController@edit    (formulario editar)
//   PUT    /productos/{id}      → ProductoController@update  (guardar cambios)
//   DELETE /productos/{id}      → ProductoController@destroy (eliminar)
//
// Para ver todas las rutas generadas: php artisan route:list
Route::resource('productos', ProductoController::class);

// ============================================================
// RUTAS DE AUTENTICACIÓN (generadas por Laravel Breeze)
// ============================================================
// Si instalas Laravel Breeze (php artisan breeze:install),
// estas rutas se añaden automáticamente en auth.php.
// Por ahora las definimos manualmente de forma básica.

// Mostrar formulario de login
Route::get('/login', function () {
    // En un proyecto real esto iría a un AuthController
    return view('auth.login');
})->name('login'); // El ->name() permite usar route('login') en las vistas

// Procesar el formulario de login
Route::post('/login', function () {
    // En un proyecto real: validar, Auth::attempt(), redirect
    return redirect('/productos');
})->name('login.submit');

// Cerrar sesión
Route::post('/logout', function () {
    // En PHP nativo: session_destroy(); header('Location: /login');
    auth()->logout();
    return redirect('/login');
})->name('logout');

// ============================================================
// RUTAS CON MIDDLEWARE (proteger páginas)
// ============================================================
// El middleware 'auth' verifica que el usuario está logueado.
// Si no lo está, redirige al login automáticamente.
//
// EN PHP NATIVO en cada archivo ponías:
//   if (!isset($_SESSION['usuario_id'])) {
//       header('Location: /login.php'); exit;
//   }
//
// EN LARAVEL usas ->middleware('auth') y ya está:
//
// Route::get('/admin', function () {
//     return view('admin.dashboard');
// })->middleware('auth');
//
// O para proteger un grupo entero de rutas:
// Route::middleware('auth')->group(function () {
//     Route::get('/perfil', [PerfilController::class, 'show']);
//     Route::get('/admin', [AdminController::class, 'index']);
// });
