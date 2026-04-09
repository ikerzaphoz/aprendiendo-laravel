{{-- ============================================================ --}}
{{-- VISTA — resources/views/productos/edit.blade.php --}}
{{-- Formulario para editar un producto existente --}}
{{-- La diferencia con create.blade.php:
     1. El formulario lleva @method('PUT') para indicar que es actualización
     2. Los campos muestran los valores actuales del producto
     3. La action apunta a route('productos.update', $producto)
     ============================================================ --}}

@extends('layouts.app')
@section('titulo', 'Editar: ' . $producto->nombre)

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('productos.show', $producto) }}">{{ $producto->nombre }}</a>
                </li>
                <li class="breadcrumb-item active">Editar</li>
            </ol>
        </nav>

        <div class="card shadow-sm">
            <div class="card-header">
                <h1 class="h4 mb-0">✏️ Editar: {{ $producto->nombre }}</h1>
                <small class="text-muted">ID #{{ $producto->id }} — Creado {{ $producto->created_at->diffForHumans() }}</small>
            </div>

            <div class="card-body">

                {{-- ── DIFERENCIA CLAVE vs create.blade.php ──────────── --}}
                {{-- action apunta a productos.update con el ID del producto
                     En PHP nativo: action="/actualizar_producto.php?id=5"
                     
                     @method('PUT') es necesario porque HTML solo soporta GET y POST.
                     Laravel intercepta _method=PUT y lo trata como PUT. --}}
                <form action="{{ route('productos.update', $producto) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- ── NOMBRE ──────────────────────────────────────── --}}
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">
                            Nombre <span class="text-danger">*</span>
                        </label>
                        {{-- old('nombre', $producto->nombre):
                             - Si hubo error de validación: recupera lo que escribió el usuario
                             - Si es la primera vez: muestra el valor actual del producto
                             EN PHP NATIVO: value="<?= htmlspecialchars($producto['nombre']) ?>" --}}
                        <input type="text"
                               class="form-control @error('nombre') is-invalid @enderror"
                               id="nombre"
                               name="nombre"
                               value="{{ old('nombre', $producto->nombre) }}"
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ── DESCRIPCIÓN ─────────────────────────────────── --}}
                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-bold">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                  id="descripcion"
                                  name="descripcion"
                                  rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        {{-- ── PRECIO ──────────────────────────────────── --}}
                        <div class="col-md-6 mb-3">
                            <label for="precio" class="form-label fw-bold">
                                Precio (€) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">€</span>
                                <input type="number"
                                       class="form-control @error('precio') is-invalid @enderror"
                                       id="precio"
                                       name="precio"
                                       value="{{ old('precio', $producto->precio) }}"
                                       step="0.01"
                                       min="0"
                                       required>
                                @error('precio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- ── STOCK ───────────────────────────────────── --}}
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-bold">
                                Stock (unidades) <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   class="form-control @error('stock') is-invalid @enderror"
                                   id="stock"
                                   name="stock"
                                   value="{{ old('stock', $producto->stock) }}"
                                   min="0"
                                   required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ── ACTIVO ──────────────────────────────────────── --}}
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            {{-- old('activo', $producto->activo):
                                 - Si hubo error: el valor que marcó el usuario
                                 - Si primera vez: el estado actual del producto --}}
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="activo"
                                   name="activo"
                                   value="1"
                                   {{ old('activo', $producto->activo) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="activo">
                                Producto activo (visible en la tienda)
                            </label>
                        </div>
                    </div>

                    {{-- ── BOTONES ─────────────────────────────────────── --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            💾 Actualizar Producto
                        </button>
                        <a href="{{ route('productos.show', $producto) }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                    </div>

                </form>
            </div>

            <div class="card-footer text-muted small">
                💡 <strong>¿Qué pasa al enviar?</strong>
                El formulario hace PUT a <code>/productos/{{ $producto->id }}</code> →
                <code>ProductoController@update()</code> valida →
                <code>$producto->update()</code> hace UPDATE en la BD →
                redirige al detalle con mensaje de éxito.
            </div>
        </div>

    </div>
</div>

@endsection
