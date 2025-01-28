@extends('adminlte::page') <!-- Extiende la plantilla AdminLTE -->

@section('title', 'Editar Usuario') <!-- Define el título de la página -->

@section('content_header')
    <h1>Editar Usuario</h1> <!-- Encabezado principal -->
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Mostrar errores si existen -->
            @includeif('partials.errors')

            <div class="card shadow-sm border-2" style="border-color: var(--color-primary); border-radius: 8px;">
                <div class="card-header bg-primary text-white" style="border-radius: 8px 8px 0 0;">
                    <h5 class="mb-0">Formulario de Edición de Usuario</h5>
                </div>
                <div class="card-body">
                    <!-- Formulario para editar un usuario existente -->
                    <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}" role="form" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH') <!-- Indica que es una actualización de recurso -->

                        <!-- Campos del formulario -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="{{ $usuario->nombre }}" class="form-control" placeholder="Nombre completo" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" id="email" value="{{ $usuario->email }}" class="form-control" placeholder="Correo electrónico" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" value="{{ $usuario->telefono }}" class="form-control" placeholder="Teléfono">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Dejar vacío si no desea cambiarla">
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select name="rol" id="rol" class="form-select" required>
                                <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="user" {{ $usuario->rol == 'user' ? 'selected' : '' }}>Usuario</option>
                            </select>
                        </div>

                        <!-- Botones de acción -->
                        <div class="mt-3 d-flex justify-content-between">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-success">Actualizar</button>
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
        .bg-primary {
            background-color: var(--color-primary) !important;
        }

        .btn-success {
            background-color: var(--color-secondary);
        }

        .btn-danger {
            background-color: #dc3545;
            color: var(--color-white);
        }

        .btn-success:hover,
        .btn-danger:hover {
            opacity: 0.8;
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Formulario de edición cargado.');
    </script>
@stop
