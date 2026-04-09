# 🚀 Cómo subir el proyecto a GitHub

Sigue estos pasos en orden desde tu terminal.

---

## PASO 1 — Crear el repositorio en GitHub

Ve a https://github.com/new y crea un repositorio con estos datos:

- **Repository name:** `aprendiendo-laravel`
- **Description:** `Proyecto educativo: Laravel explicado desde PHP nativo, con comentarios en cada archivo`
- **Visibility:** Public (para que puedas compartirlo)
- ❌ NO marques "Add a README file" (ya lo tenemos)
- Haz clic en **"Create repository"**

---

## PASO 2 — Instalar Laravel en tu máquina (si no lo tienes)

```bash
# Opción A: Con Composer (recomendado)
composer create-project laravel/laravel aprendiendo-laravel
cd aprendiendo-laravel

# Opción B: Con el instalador de Laravel
composer global require laravel/installer
laravel new aprendiendo-laravel
cd aprendiendo-laravel
```

---

## PASO 3 — Copiar los archivos educativos encima del proyecto

Descomprime el ZIP que descargaste y copia TODOS los archivos
dentro de la carpeta `aprendiendo-laravel/` que Laravel creó.

Cuando te pregunte si quieres sobreescribir, di que SÍ para:
- `routes/web.php`
- `app/Models/` (añade `Producto.php`)
- `app/Http/Controllers/` (añade `ProductoController.php`)
- `database/migrations/` (añade la migración de productos)
- `database/seeders/` (sobreescribe los seeders)
- `resources/views/` (añade las carpetas layouts, productos, auth)
- `README.md`

---

## PASO 4 — Configurar el proyecto

```bash
# Copiar la configuración de ejemplo
cp .env.example .env

# Generar la clave de seguridad de la app
php artisan key:generate

# Editar .env con tus datos de base de datos
# Busca estas líneas y cámbialas:
#   DB_DATABASE=aprendiendo_laravel
#   DB_USERNAME=root
#   DB_PASSWORD=tu_contraseña
nano .env   # o ábrelo con tu editor favorito
```

---

## PASO 5 — Crear la base de datos y las tablas

```bash
# Primero crea la base de datos en MySQL:
mysql -u root -p -e "CREATE DATABASE aprendiendo_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Luego ejecuta las migraciones (crea las tablas)
php artisan migrate

# Opcional: cargar los productos de ejemplo
php artisan db:seed
```

---

## PASO 6 — Inicializar Git y subir a GitHub

```bash
# Inicializar repositorio Git (si no existe ya)
git init

# Añadir todos los archivos al staging
git add .

# Primer commit
git commit -m "🎓 Proyecto educativo Laravel - CRUD de productos comentado"

# Conectar con tu repositorio de GitHub
# (sustituye TU_USUARIO por tu nombre de usuario de GitHub)
git remote add origin https://github.com/TU_USUARIO/aprendiendo-laravel.git

# Subir el código
git branch -M main
git push -u origin main
```

---

## PASO 7 — Probar que funciona

```bash
# Arrancar el servidor de desarrollo
php artisan serve

# Visita en el navegador:
# http://localhost:8000
```

Deberías ver la lista de productos (vacía si no ejecutaste el seeder,
o con 5 productos de ejemplo si lo ejecutaste).

---

## Resumen de comandos útiles para el día a día

```bash
# Arrancar servidor
php artisan serve

# Ver todas las rutas
php artisan route:list

# Crear un Controller nuevo
php artisan make:controller NombreController --resource

# Crear un Modelo + Migración de una vez
php artisan make:model NombreModelo -m

# Ejecutar migraciones
php artisan migrate

# Resetear BD y recargar datos de prueba
php artisan migrate:fresh --seed

# Consola interactiva (¡muy útil para probar Eloquent!)
php artisan tinker
>>> Producto::all()
>>> Producto::find(1)
>>> Producto::where('activo', true)->count()
```

---

## Estructura final del repositorio

```
aprendiendo-laravel/
├── routes/web.php                          ← 🗺️  El router
├── app/
│   ├── Http/Controllers/
│   │   └── ProductoController.php          ← 🧠 La lógica
│   └── Models/
│       └── Producto.php                    ← 🗄️  El modelo (tabla BD)
├── database/
│   ├── migrations/
│   │   └── ..._create_productos_table.php  ← 🏗️  Crea la tabla
│   └── seeders/
│       ├── DatabaseSeeder.php              ← 🌱 Orquestador de seeders
│       └── ProductoSeeder.php              ← 🌱 Datos de prueba
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php                  ← 🖼️  Plantilla base (header/footer)
│   ├── productos/
│   │   ├── index.blade.php                ← 📋 Lista de productos
│   │   ├── show.blade.php                 ← 🔍 Detalle de un producto
│   │   ├── create.blade.php               ← ➕ Formulario crear
│   │   └── edit.blade.php                 ← ✏️  Formulario editar
│   └── auth/
│       └── login.blade.php                ← 🔐 Formulario login
├── .env.example                           ← ⚙️  Plantilla de configuración
├── .gitignore                             ← 🚫 Archivos que NO van a Git
├── composer.json                          ← 📦 Dependencias PHP
└── README.md                              ← 📖 Documentación del proyecto
```
