@extends('adminlte::page') <!-- Extiende la plantilla AdminLTE -->

@section('title', 'Crear Categoría') <!-- Define un título descriptivo -->

@section('content_header')
<h1 style="color: var(--color-primary); font-weight: bold; text-align: center;">Crear Nueva Categoría</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Mostrar mensajes de éxito o errores -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Tarjeta del formulario -->
            <div class="card shadow-sm border-2" style="border-color: var(--color-primary); border-radius: 8px;">
                <div class="card-header bg-primary text-white" style="border-radius: 8px 8px 0 0;">
                    <h5 class="mb-0">Formulario de Creación de Categoría</h5>
                </div>
                <div class="card-body">
                    <!-- Formulario para crear una nueva categoría -->
                    <form method="POST" action="{{ route('categorias.store') }}" role="form">
                        @csrf <!-- Token CSRF para proteger el formulario -->

                        <!-- Campo Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Categoría</label>
                            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                   value="{{ old('nombre') }}" placeholder="Ingrese el nombre de la categoría" required>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Campo Año -->
                        <div class="mb-3">
                            <label for="anio" class="form-label">Año</label>
                            <input type="number" name="anio" id="anio" class="form-control @error('anio') is-invalid @enderror"
                                   value="{{ old('anio') }}" placeholder="Ingrese el año" required>
                            @error('anio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Campo Ciclo Escolar -->
                        <div class="mb-3">
                            <label for="ciclo" class="form-label">Ciclo Escolar</label>
                            <select name="ciclo" id="ciclo" class="form-select @error('ciclo') is-invalid @enderror" required>
                                <option value="">Seleccione</option>
                                <option value="A" {{ old('ciclo') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('ciclo') == 'B' ? 'selected' : '' }}>B</option>
                            </select>
                            @error('ciclo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Botón de guardar -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('categorias.index') }}" class="btn btn-danger">Cancelar</a>
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
    </style>
@stop

@section('js')
    <script>
        console.log('Formulario de creación de categoría cargado.');
    </script>
@stop
