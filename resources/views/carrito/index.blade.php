@extends('adminlte::page')

@section('content')

<div class="container mt-4">
    <h1 class="text-center mb-4">Catálogo de Libros</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Libro</th>
                    <th>Precio</th>
                    <th>Código</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->producto }}</td>
                        <td>${{ number_format($producto->precio_venta, 2) }}</td>
                        <td>{{ $producto->codigo }}</td>
                        <td>{{ $producto->stock }}</td>
                        <td>
                            @if ($producto->foto)
                            <img src="{{ asset('storage/ima/' . $uploads->foto) }}" alt="Imagen del Libro" style="max-width: 100px; max-height: 100px;">
                            @else
                                <span>Sin imagen</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Agregar al Carrito</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay libros disponibles en este momento.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
