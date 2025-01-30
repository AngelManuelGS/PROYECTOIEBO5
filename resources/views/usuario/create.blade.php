@extends('adminlte::page')

@section('title', 'Nuevo Usuario')

@section('content_header')
    <h1 class="text-center" style="color: var(--color-primary); font-weight: bold;">Crear Nuevo Usuario</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Mostrar errores si existen -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm border-2 border-primary rounded-lg">
                <div class="card-header bg-primary text-white rounded-top">
                    <h5 class="mb-0">Formulario de Creación de Usuario</h5>
                </div>
                <div class="card-body">
                    <!-- Formulario para crear un nuevo usuario -->
                    <form method="POST" action="{{ route('usuarios.store') }}" role="form">
                        @csrf

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Nombre completo" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Correo electrónico" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Teléfono -->
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror"
                                   placeholder="Teléfono" value="{{ old('telefono') }}" required>
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Contraseña" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Rol -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="cliente" {{ old('role') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campos adicionales para Cliente -->
                        <div id="campos-cliente" style="display: none;">
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" name="direccion" id="direccion" class="form-control"
                                       placeholder="Ingrese la dirección" value="{{ old('direccion') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="plantel_educativo" class="form-label">Plantel Educativo</label>
                                <input type="text" name="plantel_educativo" id="plantel_educativo" class="form-control"
                                       placeholder="Ingrese el plantel educativo" value="{{ old('plantel_educativo') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="region" class="form-label">Región</label>
                                <input type="text" name="region" id="region" class="form-control"
                                       placeholder="Ingrese la región" value="{{ old('region') }}" required>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="mt-3 d-flex justify-content-between">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar</button>
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
        document.addEventListener("DOMContentLoaded", function () {
            let roleSelect = document.getElementById("role");
            let camposCliente = document.getElementById("campos-cliente");

            function toggleCamposCliente() {
                if (roleSelect.value === "cliente") {
                    camposCliente.style.display = "block";
                } else {
                    camposCliente.style.display = "none";
                }
            }

            roleSelect.addEventListener("change", toggleCamposCliente);

            // Ejecutar al cargar la página (para cuando el usuario ya tiene un rol seleccionado)
            toggleCamposCliente();
        });
    </script>
@stop
