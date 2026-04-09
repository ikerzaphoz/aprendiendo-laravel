{{-- ============================================================ --}}
{{-- LAYOUT BASE — resources/views/layouts/app.blade.php --}}
{{-- ============================================================ --}}
{{-- Esta es tu plantilla base: el HTML que se repite en todas las páginas.
     En PHP nativo tenías header.php y footer.php que hacías include.
     En Laravel tienes @extends y @yield/@section.
     
     CÓMO FUNCIONA:
     - Este archivo define la estructura HTML completa
     - Los "huecos" se definen con @yield('nombre')
     - Las vistas hijas rellenan esos huecos con @section('nombre')
     
     EN PHP NATIVO:
       include 'header.php';
       // ... contenido de la página ...
       include 'footer.php';
     
     EN LARAVEL (en la vista hija):
       @extends('layouts.app')
       @section('content')
         <!-- ... contenido de la página ... -->
       @endsection
     ============================================================ --}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- @yield('titulo') → aquí irá el título de cada página
         Si la vista hija no define 'titulo', usará "Aprendiendo Laravel" --}}
    <title>@yield('titulo', 'Aprendiendo Laravel')</title>

    {{-- Meta CSRF: necesario para que los formularios funcionen en Laravel.
         Laravel rechaza formularios sin este token para prevenir ataques CSRF.
         En PHP nativo esto lo hacías manualmente con tokens en sesión. --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Estilos CSS - usamos Bootstrap via CDN para simplicidad --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- @stack('styles') permite que las vistas hijas añadan CSS extra
         Con @push('styles') ... @endpush en la vista hija --}}
    @stack('styles')

    <style>
        /* Estilos básicos del proyecto */
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; color: #FF2D20 !important; }
        .btn-laravel { background-color: #FF2D20; color: white; }
        .btn-laravel:hover { background-color: #cc2419; color: white; }
        .badge-stock-ok { background-color: #198754; }
        .badge-sin-stock { background-color: #dc3545; }
    </style>
</head>
<body>

    {{-- ── NAVEGACIÓN ──────────────────────────────────────────── --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">

            {{-- route('productos.index') genera la URL /productos
                 En PHP nativo escribías href="/productos.php"
                 route() es mejor porque si cambias la URL, todos los links se actualizan solos --}}
            <a class="navbar-brand" href="{{ route('productos.index') }}">
                ⚡ Aprendiendo Laravel
            </a>

            <div class="navbar-nav ms-auto">
                <a class="nav-link text-white" href="{{ route('productos.index') }}">Productos</a>
                <a class="nav-link text-white" href="{{ route('productos.create') }}">+ Nuevo</a>
            </div>
        </div>
    </nav>

    {{-- ── CONTENIDO PRINCIPAL ─────────────────────────────────── --}}
    <div class="container">

        {{-- ── MENSAJES FLASH ─────────────────────────────────── --}}
        {{-- Los mensajes flash son datos guardados en sesión que
             desaparecen después de mostrarse una vez.
             Los enviamos desde el Controller con ->with('exito', 'mensaje').
             
             EN PHP NATIVO:
               $_SESSION['mensaje'] = 'Guardado';
               // En la vista: if (isset($_SESSION['mensaje'])) { echo $_SESSION['mensaje']; }
             
             EN LARAVEL usamos @session() de Blade --}}

        @if(session('exito'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ✅ {{ session('exito') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ❌ {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ── ERRORES DE VALIDACIÓN GLOBALES ────────────────── --}}
        {{-- Cuando la validación falla en el Controller, Laravel
             redirige al formulario con los errores disponibles en $errors --}}
        @if($errors->any())
            <div class="alert alert-warning">
                <strong>⚠️ Corrige los siguientes errores:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ── AQUÍ VA EL CONTENIDO DE CADA PÁGINA ───────────── --}}
        {{-- @yield('content') es el "hueco" que rellenan las vistas hijas
             con @section('content') ... @endsection --}}
        @yield('content')

    </div>

    {{-- ── PIE DE PÁGINA ───────────────────────────────────────── --}}
    <footer class="mt-5 py-4 bg-dark text-center text-white-50">
        <small>
            Proyecto educativo — Aprendiendo Laravel desde PHP nativo
            <br>
            <a href="https://laravel.com/docs" class="text-white-50" target="_blank">📚 Documentación oficial de Laravel</a>
        </small>
    </footer>

    {{-- JavaScript de Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- @stack('scripts') para que las vistas hijas añadan JS extra --}}
    @stack('scripts')

</body>
</html>
