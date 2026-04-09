# 🎓 Aprendiendo Laravel — De PHP Nativo a Laravel

> Proyecto educativo para programadores PHP que quieren aprender Laravel.
> Cada archivo está **comentado en detalle** explicando el por qué de cada decisión.

---

## ¿Qué hace este proyecto?

Un CRUD completo de **Productos** con:
- Listar productos
- Ver detalle de un producto
- Crear producto
- Editar producto
- Eliminar producto
- Autenticación básica (login/logout)

Es lo más simple posible, pero con la estructura correcta de Laravel.

---

## Estructura del proyecto (lo que necesitas conocer)

```
aprendiendo-laravel/
│
├── routes/
│   └── web.php                  ← Aquí defines las URLs (tu router)
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── ProductoController.php  ← La lógica de negocio
│   └── Models/
│       └── Producto.php         ← Representa la tabla 'productos' en BD
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php    ← Plantilla base (tu header/footer común)
│       └── productos/
│           ├── index.blade.php  ← Lista de productos
│           ├── show.blade.php   ← Detalle de un producto
│           ├── create.blade.php ← Formulario de creación
│           └── edit.blade.php   ← Formulario de edición
│
├── database/
│   └── migrations/
│       └── create_productos_table.php  ← Script para crear la tabla en BD
│
├── .env.example                 ← Plantilla de configuración
└── composer.json                ← Dependencias del proyecto (como package.json)
```

---

## Cómo instalar este proyecto

```bash
# 1. Clonar el repositorio
git clone https://github.com/TU_USUARIO/aprendiendo-laravel.git
cd aprendiendo-laravel

# 2. Instalar dependencias PHP
composer install

# 3. Copiar el archivo de configuración
cp .env.example .env

# 4. Generar la clave de la aplicación
php artisan key:generate

# 5. Configurar tu base de datos en .env
# Edita DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 6. Crear las tablas en la base de datos
php artisan migrate

# 7. (Opcional) Cargar datos de prueba
php artisan db:seed

# 8. Arrancar el servidor de desarrollo
php artisan serve
# → Visita http://localhost:8000
```

---

## Flujo de una petición — El concepto más importante

```
Usuario visita /productos
       ↓
routes/web.php → encuentra Route::get('/productos', ...)
       ↓
ProductoController@index → consulta la BD con Eloquent
       ↓
Producto::all() → SELECT * FROM productos
       ↓
return view('productos.index', ['productos' => $productos])
       ↓
resources/views/productos/index.blade.php → HTML final
       ↓
El usuario ve la lista de productos
```

---

## Comparativa rápida: PHP Nativo vs Laravel

| Concepto | PHP Nativo | Laravel |
|---|---|---|
| Router | `if($_GET['page'] == 'x')` | `Route::get('/x', ...)` |
| Base de datos | `$pdo->prepare('SELECT...')` | `Producto::all()` |
| Plantillas | `include 'header.php'` | `@extends('layouts.app')` |
| Formularios | `$_POST['campo']` | `$request->campo` |
| Validación | Manual con if/else | `$request->validate([...])` |
| Configuración | `define('DB_HOST', ...)` | Archivo `.env` |

---

## Archivos a estudiar en este orden

1. `routes/web.php` — Empieza aquí, entiende las URLs
2. `app/Models/Producto.php` — El modelo (tabla en BD)
3. `database/migrations/` — Cómo se crea la tabla
4. `app/Http/Controllers/ProductoController.php` — La lógica
5. `resources/views/layouts/app.blade.php` — La plantilla base
6. `resources/views/productos/` — Las vistas del CRUD

---

*Creado para aprender Laravel comparando con PHP nativo. Cada línea tiene comentarios explicativos.*
