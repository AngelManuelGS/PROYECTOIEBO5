@extends('adminlte::page') <!-- Extiende la plantilla AdminLTE -->

@section('title', 'Crear Libro') <!-- Define un título descriptivo -->

@section('content_header')
    <!-- Encabezado principal con estilo consistente -->
    <h1 style="color: var(--color-primary); font-weight: bold;">Crear Nuevo Libro</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Incluye un contenedor de fila de Bootstrap con una columna que ocupa todo el ancho (12 columnas) -->

            @includeif('partials.errors')
            <!-- Incluye el archivo 'partials.errors' si existe, para mostrar errores de validación -->

            <div class="card card-default">
                <div class="card-header">
                    <!-- Título de la tarjeta, indicando que se está creando un nuevo producto -->
                    <span class="card-title">{{ __('Crear') }} Libros</span>
                </div>
                <div class="card-body">
                    <!-- Formulario para enviar datos del nuevo producto al controlador -->
                    <form method="POST" action="{{ route('productos.store') }}" role="form" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <!-- Token CSRF para proteger el formulario contra ataques de falsificación de solicitudes -->

                        @include('producto.form')
                        <!-- Incluye el archivo 'producto.form' para mantener los campos del formulario separados y organizados -->

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

        h1 {
            font-family: 'Arial', sans-serif; /* Fuente consistente */
            font-weight: bold;
            color: var(--color-primary);
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Formulario de creación de libro cargado.');
    </script>
@stop
