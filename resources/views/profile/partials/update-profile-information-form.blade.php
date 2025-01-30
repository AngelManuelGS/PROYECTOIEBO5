@extends('adminlte::page')

@section('title', 'Perfil de Usuario')

@section('content_header')
    <h1 class="text-center" style="color: var(--color-primary); font-weight: bold;">Perfil de Usuario</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Tarjeta para actualizar la información del perfil -->
            <div class="card shadow-sm border-2" style="border-color: var(--color-primary); border-radius: 8px;">
                <div class="card-header bg-primary text-white" style="border-radius: 8px 8px 0 0;">
                    <h5 class="mb-0">Actualizar Información de Perfil</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" name="name" id="name" class="form-control"
                                   value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-secondary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tarjeta para actualizar la contraseña -->
            <div class="card shadow-sm border-2 mt-4" style="border-color: #f8b400; border-radius: 8px;">
                <div class="card-header text-white" style="background-color: #f8b400; border-radius: 8px 8px 0 0;">
                    <h5 class="mb-0">Actualizar Contraseña</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual</label>
                            <input type="password" name="current_password" id="current_password" class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tarjeta para eliminar la cuenta -->
            <div class="card shadow-sm border-2 mt-4" style="border-color: #dc3545; border-radius: 8px;">
                <div class="card-header text-white" style="background-color: #dc3545; border-radius: 8px 8px 0 0;">
                    <h5 class="mb-0">Eliminar Cuenta</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Una vez que elimine su cuenta, todos sus datos y recursos serán eliminados permanentemente. Antes de proceder, descargue cualquier información que desee conservar.
                    </p>

                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control"
                                   required placeholder="Ingrese su contraseña para confirmar">
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-danger">Eliminar Cuenta</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        :root {
            --color-primary: #285C4D;
            --color-secondary: #B38E5D;
            --color-white: #ffffff;
        }

        .bg-primary {
            background-color: var(--color-primary) !important;
        }

        .btn-warning {
            background-color: #f8b400;
            color: var(--color-white);
            border: none;
        }

        .btn-secondary {
            background-color: #8d8d8d;
            color: var(--color-white);
            border: none;
        }

        .btn-danger {
            background-color: #dc3545;
            color: var(--color-white);
            border: none;
        }

        .btn-warning:hover,
        .btn-secondary:hover,
        .btn-danger:hover {
            opacity: 0.8;
        }

        h1 {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            color: var(--color-primary);
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Vista de perfil de usuario cargada correctamente.');
    </script>
@stop
