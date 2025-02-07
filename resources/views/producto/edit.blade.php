@extends('adminlte::page')
<!-- Extiende la plantilla AdminLTE para dar formato a la página -->

@section('title', 'Actualizar Libro')
<!-- Define el título de la página como "Actualizar Libro" -->

@section('content_header')
    <!-- Encabezado principal con estilo consistente -->
    <h1 class="text-center" style="color: var(--color-primary); font-weight: bold;">Actualizar Libro</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Contenedor principal con una columna de tamaño medio -->

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Mostrar errores si existen -->

            <div class="card shadow-sm border-2 border-primary rounded-lg">
                <div class="card-header bg-primary text-white rounded-top">
                    <!-- Título de la tarjeta -->
                    <h5 class="mb-0">Formulario de Actualización de Libro</h5>
                </div>
                <div class="card-body" style="background-color: #ffffff;">
                    <!-- Formulario para actualizar el libro -->
                    <form method="POST" action="{{ route('productos.update', $producto->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH') <!-- Método PATCH para indicar que es una actualización -->

                        <ul class="list-unstyled">
                            <!-- Código -->
                            <li class="mb-3">
                                <label for="codigo" class="form-label">Código</label>
                                <input type="text" name="codigo" id="codigo" class="form-control @error('codigo') is-invalid @enderror"
                                       placeholder="Ingrese el código del libro" value="{{ old('codigo', $producto->codigo) }}" required>
                                @error('codigo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </li>

                            <!-- Nombre del Libro -->
                            <li class="mb-3">
                                <label for="producto" class="form-label">Nombre del Libro</label>
                                <input type="text" name="producto" id="producto" class="form-control @error('producto') is-invalid @enderror"
                                       placeholder="Ingrese el nombre del libro" value="{{ old('producto', $producto->producto) }}" required>
                                @error('producto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </li>

                            <!-- Precio de Compra -->
                            <li class="mb-3">
                                <label for="precio_compra" class="form-label">Precio de Compra</label>
                                <input type="number" step="0.01" name="precio_compra" id="precio_compra" class="form-control @error('precio_compra') is-invalid @enderror"
                                       placeholder="Ingrese el precio de compra" value="{{ old('precio_compra', $producto->precio_compra) }}" required>
                                @error('precio_compra')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </li>

                            <!-- Precio de Venta -->
                            <li class="mb-3">
                                <label for="precio_venta" class="form-label">Precio de Venta</label>
                                <input type="number" step="0.01" name="precio_venta" id="precio_venta" class="form-control @error('precio_venta') is-invalid @enderror"
                                       placeholder="Ingrese el precio de venta" value="{{ old('precio_venta', $producto->precio_venta) }}" required>
                                @error('precio_venta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </li>

                            <!-- Stock -->
                            <li class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror"
                                       placeholder="Ingrese el stock disponible" value="{{ old('stock', $producto->stock) }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </li>

                            <!-- Categoría -->
                            <li class="mb-3">
                                <label for="id_categoria" class="form-label">Categoría</label>
                                <select name="id_categoria" id="id_categoria" class="form-control @error('id_categoria') is-invalid @enderror">
                                    <option value="">Selecciona una categoría</option>
                                    @foreach ($categorias as $id => $nombre)
                                        <option value="{{ $id }}" {{ old('id_categoria', $producto->id_categoria) == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                    @endforeach
                                </select>
                                @error('id_categoria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </li>

                            <!-- Imagen del Libro -->
                            <li class="mb-3">
                                <label for="foto" class="form-label">Imagen del Libro</label>
                                <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </li>
                        </ul>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('productos.index') }}" class="btn btn-danger">Regresar</a>
                            <button type="submit" class="btn btn-success">Guardar Cambios</button>
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

        h1 {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            color: var(--color-primary);
        }

        .list-unstyled li {
            margin-bottom: 15px;
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Formulario de Actualización de Libro cargado correctamente.');
    </script>
@stop
