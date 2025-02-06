@extends('adminlte::page') <!-- Extiende la plantilla AdminLTE -->

@section('title', 'Editar Cliente') <!-- Define el título de la página -->

@section('content_header')
    <h1 class="text-center font-weight-bold" style="color: var(--color-primary);">Editar Cliente</h1> <!-- Encabezado -->
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
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
            <div class="card shadow-sm border-2" style="border-color: var(--color-primary); border-radius: 8px;">
                <div class="card-header bg-primary text-white text-center" style="border-radius: 8px 8px 0 0;">
                    <h5 class="mb-0">Formulario de Edición de Cliente</h5>
                </div>

                <div class="card-body">
                    <!-- Formulario para editar cliente -->
                    <form method="POST" action="{{ route('clientes.update', $cliente->id) }}" role="form" id="formCliente">
                        @csrf
                        @method('PUT') <!-- Método HTTP para actualización -->

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                value="{{ old('nombre', $cliente->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $cliente->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Dejar vacío si no desea cambiarla">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror"
                                value="{{ old('telefono', $cliente->telefono) }}" required>
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea name="direccion" id="direccion" class="form-control @error('direccion') is-invalid @enderror"
                                rows="3" required>{{ old('direccion', $cliente->direccion) }}</textarea>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="plante_educativo" class="form-label">Plantel Educativo</label>
                            <input type="text" name="plante_educativo" id="plante_educativo" class="form-control @error('plante_educativo') is-invalid @enderror"
                                value="{{ old('plante_educativo', $cliente->plante_educativo) }}" required>
                            @error('plante_educativo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="region" class="form-label">Región</label>
                            <input type="text" name="region" id="region" class="form-control @error('region') is-invalid @enderror"
                                value="{{ old('region', $cliente->region) }}" required>
                            @error('region')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Actualizar Cliente</button>
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

        .btn-success {
            background-color: var(--color-secondary);
            color: var(--color-white);
            border: none;
        }

        .btn-danger {
            background-color: #dc3545;
            color: var(--color-white);
            border: none;
        }

        .btn-success:hover,
        .btn-danger:hover {
            opacity: 0.8;
        }

        h1 {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            color: var(--color-primary);
        }

        .is-invalid {
            border-color: red !important;
        }
    </style>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('#formCliente').addEventListener('submit', function (e) {
                let campos = ['nombre', 'email', 'telefono', 'direccion', 'plante_educativo', 'region'];
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
