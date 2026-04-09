{{-- ============================================================ --}}
{{-- VISTA — resources/views/productos/create.blade.php --}}
{{-- Formulario para crear un producto nuevo --}}
{{-- ============================================================ --}}

@extends('layouts.app')
@section('titulo', 'Nuevo Producto')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- Migas de pan --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
                <li class="breadcrumb-item active">Nuevo Producto</li>
            </ol>
        </nav>

        <div class="card shadow-sm">
            <div class="card-header">
                <h1 class="h4 mb-0">➕ Nuevo Producto</h1>
            </div>

            <div class="card-body">

                {{-- ── FORMULARIO ─────────────────────────────────────── --}}
                {{-- action: a dónde se envía el formulario. route('productos.store') = POST /productos
                     method: siempre POST en HTML. Para PUT/DELETE se usa @method('PUT') --}}
                <form action="{{ route('productos.store') }}" method="POST">

                    {{-- @csrf es OBLIGATORIO en todos los formularios de Laravel.
                         Genera: <input type="hidden" name="_token" value="...">
                         Protege contra ataques CSRF (Cross-Site Request Forgery).
                         Sin esto el formulario dará error 419. --}}
                    @csrf

                    {{-- ── CAMPO: NOMBRE ──────────────────────────────── --}}
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">
                            Nombre <span class="text-danger">*</span>
                        </label>
                        {{-- old('nombre') recupera el valor que escribió el usuario
                             si la validación falló y tuvo que corregir errores.
                             EN PHP NATIVO: $_SESSION['form_nombre'] ?? ''
                             
                             @error('nombre') aplica la clase CSS de error si ese campo falló --}}
                        <input type="text"
                               class="form-control @error('nombre') is-invalid @enderror"
                               id="nombre"
                               name="nombre"
                               value="{{ old('nombre') }}"
                               placeholder="Ej: Laptop HP Pavilion 15"
                               required>

                        {{-- @error('campo') muestra el mensaje de error de ese campo --}}
                        @error('nombre')
                            {{-- $message contiene el error: "El campo nombre es obligatorio" --}}
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ── CAMPO: DESCRIPCIÓN ─────────────────────────── --}}
                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-bold">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                  id="descripcion"
                                  name="descripcion"
                                  rows="3"
                                  placeholder="Describe el producto...">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Opcional. Describe características, materiales, etc.</div>
                    </div>

                    <div class="row">
                        {{-- ── CAMPO: PRECIO ──────────────────────────── --}}
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
                                       value="{{ old('precio', '0.00') }}"
                                       step="0.01"
                                       min="0"
                                       required>
                                @error('precio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- ── CAMPO: STOCK ────────────────────────────── --}}
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-bold">
                                Stock (unidades) <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   class="form-control @error('stock') is-invalid @enderror"
                                   id="stock"
                                   name="stock"
                                   value="{{ old('stock', '0') }}"
                                   min="0"
                                   required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ── CAMPO: ACTIVO ───────────────────────────────── --}}
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            {{-- checked="checked" si old('activo') es true, o si es un formulario nuevo (por defecto activo) --}}
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="activo"
                                   name="activo"
                                   value="1"
                                   {{ old('activo', '1') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="activo">
                                Producto activo (visible en la tienda)
                            </label>
                        </div>
                    </div>

                    {{-- ── BOTONES ─────────────────────────────────────── --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-laravel">
                            💾 Guardar Producto
                        </button>
                        <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                    </div>

                </form>
            </div>

            <div class="card-footer text-muted small">
                {{-- Nota educativa --}}
                💡 <strong>¿Qué pasa al enviar?</strong>
                El formulario hace POST a <code>/productos</code> →
                <code>ProductoController@store()</code> valida los datos →
                <code>Producto::create()</code> guarda en la BD →
                redirige a la lista con un mensaje de éxito.
            </div>
        </div>

    </div>
</div>

@endsection
