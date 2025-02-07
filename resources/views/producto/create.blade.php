@extends('adminlte::page')

@section('title', 'Crear Libro')

@section('content_header')
<h1 class="text-center" style="color: var(--color-primary); font-weight: bold;">Crear Nuevo Libro</h1>
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
                    <h5 class="mb-0">Formulario de Creación de Libro</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Código -->
                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control @error('codigo') is-invalid @enderror"
                                   placeholder="Ingrese el código del libro" value="{{ old('codigo') }}" required>
                            @error('codigo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nombre del Libro -->
                        <div class="mb-3">
                            <label for="producto" class="form-label">Nombre del Libro</label>
                            <input type="text" name="producto" id="producto" class="form-control @error('producto') is-invalid @enderror"
                                   placeholder="Ingrese el nombre del libro" value="{{ old('producto') }}" required>
                            @error('producto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Precio de Compra -->
                        <div class="mb-3">
                            <label for="precio_compra" class="form-label">Precio de Compra</label>
                            <input type="number" step="0.01" name="precio_compra" id="precio_compra" class="form-control @error('precio_compra') is-invalid @enderror"
                                   placeholder="Ingrese el precio de compra" value="{{ old('precio_compra') }}" required>
                            @error('precio_compra')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Precio de Venta -->
                        <div class="mb-3">
                            <label for="precio_venta" class="form-label">Precio de Venta</label>
                            <input type="number" step="0.01" name="precio_venta" id="precio_venta" class="form-control @error('precio_venta') is-invalid @enderror"
                                   placeholder="Ingrese el precio de venta" value="{{ old('precio_venta') }}" required>
                            @error('precio_venta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror"
                                   placeholder="Ingrese el stock disponible" value="{{ old('stock') }}" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Categoría -->
                        <div class="mb-3">
                            <label for="id_categoria" class="form-label">Categoría</label>
                            <select name="id_categoria" id="id_categoria" class="form-control @error('id_categoria') is-invalid @enderror">
                                <option value="">Selecciona una categoría</option>
                                @foreach ($categorias as $id => $nombre)
                                    <option value="{{ $id }}" {{ old('id_categoria') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                            @error('id_categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Imagen del Libro -->
                        <div class="mb-3">
                            <label for="foto" class="form-label">Imagen del Libro</label>
                            <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('productos.index') }}" class="btn btn-danger  ">Cancelar</a>
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
