{{-- ============================================================ --}}
{{-- VISTA — resources/views/productos/show.blade.php --}}
{{-- Detalle de un producto específico --}}
{{-- ============================================================ --}}

@extends('layouts.app')
@section('titulo', $producto->nombre)

@section('content')

{{-- Migas de pan (breadcrumb) --}}
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('productos.index') }}">Productos</a>
        </li>
        {{-- {{ $producto->nombre }} muestra el valor con escape HTML automático.
             EN PHP NATIVO: echo htmlspecialchars($producto['nombre']); --}}
        <li class="breadcrumb-item active">{{ $producto->nombre }}</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0">{{ $producto->nombre }}</h1>

                {{-- Mostramos el estado del producto --}}
                @if($producto->activo)
                    <span class="badge bg-success">Activo</span>
                @else
                    <span class="badge bg-secondary">Inactivo</span>
                @endif
            </div>

            <div class="card-body">
                {{-- Descripción --}}
                @if($producto->descripcion)
                    <p class="lead">{{ $producto->descripcion }}</p>
                    <hr>
                @endif

                {{-- Detalles en tabla --}}
                <table class="table table-borderless">
                    <tr>
                        <th class="text-muted" style="width:150px">Precio</th>
                        <td>
                            {{-- Usamos el método del Modelo para formatear --}}
                            <strong class="fs-4 text-success">{{ $producto->precioFormateado() }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">Stock</th>
                        <td>
                            @if($producto->stock > 0)
                                <span class="badge badge-stock-ok fs-6">{{ $producto->stock }} unidades disponibles</span>
                            @else
                                <span class="badge badge-sin-stock fs-6">Sin stock</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">ID</th>
                        <td class="text-muted">#{{ $producto->id }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Creado</th>
                        {{-- Carbon: objeto de fecha que incluye Laravel.
                             diffForHumans() devuelve "hace 2 horas", "hace 3 días"
                             EN PHP NATIVO: date('d/m/Y H:i', strtotime($producto['created_at'])) --}}
                        <td>{{ $producto->created_at->format('d/m/Y H:i') }}
                            <small class="text-muted">({{ $producto->created_at->diffForHumans() }})</small>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">Actualizado</th>
                        <td>{{ $producto->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>

            <div class="card-footer d-flex gap-2">
                {{-- Botón Editar --}}
                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">
                    ✏️ Editar producto
                </a>

                {{-- Botón Eliminar --}}
                <form action="{{ route('productos.destroy', $producto) }}"
                      method="POST"
                      onsubmit="return confirm('¿Eliminar {{ $producto->nombre }}? Esta acción no se puede deshacer.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">🗑 Eliminar</button>
                </form>

                {{-- Botón Volver --}}
                <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary ms-auto">
                    ← Volver a la lista
                </a>
            </div>
        </div>
    </div>

    {{-- Panel lateral informativo --}}
    <div class="col-md-4">
        <div class="card shadow-sm bg-light">
            <div class="card-body">
                <h5 class="card-title">💡 Nota educativa</h5>
                <p class="card-text small text-muted">
                    Esta vista recibe el objeto <code>$producto</code> desde el Controller.
                    Laravel usó <strong>Route Model Binding</strong>: detectó el <code>{producto}</code>
                    en la URL, hizo el SELECT automáticamente y pasó el objeto.
                </p>
                <p class="card-text small text-muted">
                    Las fechas <code>created_at</code> y <code>updated_at</code>
                    son objetos <strong>Carbon</strong> que ofrecen métodos de
                    formato avanzados.
                </p>
                <hr>
                <p class="small mb-0">
                    <strong>Archivo:</strong><br>
                    <code>resources/views/productos/show.blade.php</code>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
