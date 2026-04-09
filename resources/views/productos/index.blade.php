{{-- ============================================================ --}}
{{-- VISTA — resources/views/productos/index.blade.php --}}
{{-- Lista de todos los productos --}}
{{-- ============================================================ --}}

{{-- @extends indica qué layout base usa esta vista.
     El punto es separador de carpetas: 'layouts.app' = layouts/app.blade.php
     
     EN PHP NATIVO: include 'layouts/header.php'; (al principio del archivo) --}}
@extends('layouts.app')

{{-- @section define el contenido de un @yield del layout.
     Todo lo que pongas aquí irá dentro del @yield('titulo') del layout. --}}
@section('titulo', 'Lista de Productos')

{{-- Aquí va el HTML principal de esta página.
     Irá dentro del @yield('content') del layout base. --}}
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">📦 Productos</h1>
        {{-- $total viene del Controller: 'total' => Producto::count() --}}
        <small class="text-muted">{{ $total }} productos en total</small>
    </div>

    {{-- route('productos.create') genera /productos/create --}}
    <a href="{{ route('productos.create') }}" class="btn btn-laravel">
        + Nuevo Producto
    </a>
</div>

{{-- ── TABLA DE PRODUCTOS ─────────────────────────────────────── --}}
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Creado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- @forelse es como @foreach pero con @empty para cuando no hay datos.
                     EN PHP NATIVO:
                       if (count($productos) > 0) {
                           foreach ($productos as $p) { ... }
                       } else {
                           echo '<tr><td>No hay productos</td></tr>';
                       } --}}
                @forelse($productos as $producto)
                <tr>
                    <td class="text-muted">{{ $producto->id }}</td>

                    <td>
                        {{-- route('productos.show', $producto) genera /productos/5
                             Pasamos el objeto $producto, Laravel extrae el ID solo --}}
                        <a href="{{ route('productos.show', $producto) }}" class="text-decoration-none fw-bold">
                            {{ $producto->nombre }}
                        </a>
                        @if($producto->descripcion)
                            <br><small class="text-muted">{{ Str::limit($producto->descripcion, 50) }}</small>
                        @endif
                    </td>

                    <td>
                        {{-- Usamos el método precioFormateado() que definimos en el Modelo --}}
                        <strong>{{ $producto->precioFormateado() }}</strong>
                    </td>

                    <td>
                        {{-- Mostramos el stock con color según cantidad --}}
                        @if($producto->stock > 0)
                            <span class="badge badge-stock-ok">{{ $producto->stock }} uds.</span>
                        @else
                            <span class="badge badge-sin-stock">Sin stock</span>
                        @endif
                    </td>

                    <td>
                        {{-- $producto->activo es boolean (true/false) gracias al $cast del Modelo --}}
                        @if($producto->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>

                    <td>
                        {{-- Carbon formatea las fechas. created_at es un objeto Carbon en Laravel.
                             EN PHP NATIVO: date('d/m/Y', strtotime($producto['created_at'])) --}}
                        <small class="text-muted">{{ $producto->created_at->format('d/m/Y') }}</small>
                    </td>

                    <td>
                        <div class="d-flex gap-1">
                            {{-- Botón Ver --}}
                            <a href="{{ route('productos.show', $producto) }}"
                               class="btn btn-sm btn-outline-primary" title="Ver">👁</a>

                            {{-- Botón Editar --}}
                            <a href="{{ route('productos.edit', $producto) }}"
                               class="btn btn-sm btn-outline-warning" title="Editar">✏️</a>

                            {{-- Botón Eliminar --}}
                            {{-- Los navegadores solo soportan GET y POST en formularios.
                                 Para enviar DELETE, Laravel usa un campo oculto _method.
                                 @method('DELETE') añade: <input type="hidden" name="_method" value="DELETE"> --}}
                            <form action="{{ route('productos.destroy', $producto) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Seguro que quieres eliminar este producto?')">
                                {{-- @csrf añade el token de seguridad para el formulario.
                                     SIN ESTO el formulario fallará. Laravel lo exige por seguridad.
                                     EN PHP NATIVO: <input type="hidden" name="token" value="..."> manual --}}
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>

                @empty
                {{-- Este bloque se muestra si $productos está vacío --}}
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <div style="font-size: 3rem">📭</div>
                        <p>No hay productos todavía.</p>
                        <a href="{{ route('productos.create') }}" class="btn btn-laravel">
                            Crear el primero
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── PAGINACIÓN ──────────────────────────────────────────────── --}}
{{-- $productos->links() genera automáticamente los botones de
     "Anterior / 1 / 2 / 3 / Siguiente".
     Esto funciona porque usamos paginate(10) en el Controller,
     no all().
     EN PHP NATIVO: cálculos manuales de LIMIT/OFFSET + botones HTML. --}}
<div class="mt-3 d-flex justify-content-center">
    {{ $productos->links() }}
</div>

@endsection
