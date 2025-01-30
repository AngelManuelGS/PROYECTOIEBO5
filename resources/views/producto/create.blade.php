@extends('adminlte::page') <!-- Extiende la plantilla de AdminLTE -->

@section('title', 'Crear Libro') <!-- Define un título descriptivo -->

@section('content_header')
    <!-- Encabezado principal con estilos consistentes -->
    <h1 class="text-center" style="color: var(--color-primary); font-weight: bold;">Crear Nuevo Libro</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Mostrar errores si existen -->
            @includeif('partials.errors')

            <!-- Tarjeta contenedora del formulario -->
            <div class="card shadow-sm border-2" style="border-color: var(--color-primary); border-radius: 8px;">
                <div class="card-header bg-primary text-white" style="border-radius: 8px 8px 0 0;">
                    <h5 class="mb-0" style="font-family: 'Arial', sans-serif;">Formulario de Creación de Libro</h5>
                </div>
                <div class="card-body">
                    <!-- Formulario para crear un nuevo libro -->
                    <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Campos del formulario -->
                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Ingrese el código del libro" required>
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Libro</label>
                            <input type="text" name="producto" id="producto" class="form-control" placeholder="Ingrese el nombre del libro" required>
                        </div>

                        <div class="mb-3">
                            <label for="precio_compra" class="form-label">Precio de Compra</label>
                            <input type="number" step="0.01" name="precio_compra" id="precio_compra" class="form-control" placeholder="Ingrese el precio de compra" required>
                        </div>

                        <div class="mb-3">
                            <label for="precio_venta" class="form-label">Precio de Venta</label>
                            <input type="number" step="0.01" name="precio_venta" id="precio_venta" class="form-control" placeholder="Ingrese el precio de venta" required>
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" name="stock" id="stock" class="form-control" placeholder="Ingrese el stock disponible" required>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Imagen del Libro</label>
                            <input type="file" name="foto" id="foto" class="form-control">
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar Libro</button>
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
            font-family: 'Arial', sans-serif;
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
