@extends('adminlte::page') <!-- Extiende la plantilla AdminLTE -->

@section('title', 'Crear Cliente') <!-- Define el título de la página -->

@section('content_header')
    <h1 class="text-center" style="color: var(--color-primary); font-weight: bold;">Crear Cliente</h1> <!-- Encabezado principal -->
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

            <!-- Tarjeta contenedora del formulario -->
            <div class="card shadow-sm border-2 border-primary rounded-lg">
                <div class="card-header bg-primary text-white rounded-top">
                    <h5 class="mb-0">Formulario de Creación de Cliente</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('clientes.store') }}" enctype="multipart/form-data" id="formCliente">
                        @csrf

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                   placeholder="Ingrese el nombre completo" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Ingrese el correo electrónico" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Teléfono -->
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror"
                                   placeholder="Ingrese el número de teléfono" value="{{ old('telefono') }}" required>
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dirección -->
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea name="direccion" id="direccion" class="form-control @error('direccion') is-invalid @enderror"
                                      rows="3" placeholder="Ingrese la dirección completa" required>{{ old('direccion') }}</textarea>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Ingrese una contraseña" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Plantel Educativo -->
                        <div class="mb-3">
                            <label for="plante_educativo" class="form-label">Plantel Educativo</label>
                            <input type="text" name="plante_educativo" id="plante_educativo"
                                   class="form-control @error('plante_educativo') is-invalid @enderror"
                                   placeholder="Ingrese el plantel educativo" value="{{ old('plante_educativo') }}" required>
                            @error('plante_educativo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Región -->
                        <div class="mb-3">
                            <label for="region" class="form-label">Región</label>
                            <input type="text" name="region" id="region" class="form-control @error('region') is-invalid @enderror"
                                   placeholder="Ingrese la región" value="{{ old('region') }}" required>
                            @error('region')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botones de acción -->
                        <div class="mt-3 d-flex justify-content-between">
                            <a href="{{ route('clientes.index') }}" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <!-- Carga los estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .bg-primary {
            background-color: var(--color-primary) !important;
        }

        .btn-success {
            background-color: var(--color-secondary);
            color: var(--color-white);
        }

        .btn-danger {
            background-color: #dc3545;
            color: var(--color-white);
        }

        .btn-success:hover,
        .btn-danger:hover {
            opacity: 0.8;
        }

        .is-invalid {
            border-color: red !important;
        }
    </style>
@stop

@section('js')
    <!-- Scripts adicionales para validación -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('#formCliente').addEventListener('submit', function (e) {
                let campos = ['nombre', 'email', 'telefono', 'direccion', 'password', 'plante_educativo', 'region'];
                let valid = true;

                campos.forEach(id => {
                    let campo = document.getElementById(id);
                    if (campo.value.trim() === '') {
                        campo.classList.add('is-invalid');
                        valid = false;
                    } else {
                        campo.classList.remove('is-invalid');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Por favor, complete todos los campos obligatorios.',
                    });
                }
            });
        });
    </script>
@stop
