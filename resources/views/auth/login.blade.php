{{-- ============================================================ --}}
{{-- VISTA — resources/views/auth/login.blade.php --}}
{{-- Formulario de login --}}
{{-- ============================================================ --}}

@extends('layouts.app')
@section('titulo', 'Iniciar Sesión')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header text-center py-3">
                <h2 class="h4 mb-0">⚡ Aprendiendo Laravel</h2>
                <small class="text-muted">Iniciar sesión</small>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="tu@email.com"
                               required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold">Contraseña</label>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-laravel w-100">
                        Entrar →
                    </button>
                </form>
            </div>

            <div class="card-footer text-muted small text-center">
                💡 En un proyecto real, instalarías <strong>Laravel Breeze</strong>
                con <code>php artisan breeze:install</code> para tener
                login, registro y recuperación de contraseña completos.
            </div>
        </div>
    </div>
</div>

@endsection
