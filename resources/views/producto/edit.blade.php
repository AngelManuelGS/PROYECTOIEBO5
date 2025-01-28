@extends('adminlte::page')
<!-- Extiende la plantilla AdminLTE para dar formato a la página -->

@section('title', 'Actualizar Libro')
<!-- Define el título de la página como "Actualizar Libro" -->

@section('content_header')
    <!-- Encabezado principal con estilo consistente -->
    <h1 style="color: var(--color-primary); font-weight: bold;">Actualizar Libro</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Contenedor principal con una columna que ocupa todo el ancho -->

            @includeif('partials.errors')
            <!-- Incluye el archivo 'partials.errors' si existe, para mostrar mensajes de error en caso de validación fallida -->

            <div class="card shadow-sm border-2" style="border-color: var(--color-primary); border-radius: 8px;">
                <div class="card-header bg-primary text-white" style="border-radius: 8px 8px 0 0;">
                    <!-- Título de la tarjeta -->
                    <h5 class="mb-0">Formulario de Actualización de Libro</h5>
                </div>
                <div class="card-body">
                    <!-- Formulario para actualizar el libro -->
                    <form method="POST" action="{{ route('productos.update', $producto->id) }}" role="form" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH') <!-- Método PATCH para indicar que es una actualización -->

                        @include('producto.form')
                        <!-- Incluye el archivo 'producto.form' para mantener los campos organizados -->
                    </form>
                </div>
                <div class="card-footer">
                    <!-- Botón para regresar al listado de libros -->
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Regresar</a>
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
        console.log('Formulario de Actualización de Libro cargado correctamente.');
    </script>
@stop
