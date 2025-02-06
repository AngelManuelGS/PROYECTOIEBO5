@extends('adminlte::page')

@section('title', 'Catálogo de Libros')

@section('content')
<div class="container mt-4">
    <h1 class="text-center font-weight-bold mb-4" style="color: var(--color-primary);">
        <i class="fas fa-book"></i> Catálogo de Libros
    </h1>

    <div class="card shadow-sm border-2" style="border-radius: 8px; border-color: var(--color-primary);">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="bg-secondary text-white">
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
                                <td class="fw-bold">{{ $producto->producto }}</td>
                                <td class="precio-destacado">${{ number_format($producto->precio_venta, 2) }}</td>
                                <td>{{ $producto->codigo }}</td>
                                <td>
                                    <span class="badge
                                        @if ($producto->stock > 10) bg-success
                                        @elseif ($producto->stock > 0) bg-warning
                                        @else bg-danger @endif">
                                        {{ $producto->stock }}
                                    </span>
                                </td>
                                <td>
                                    @if ($producto->foto)
                                        <img src="{{ asset('storage/ima/' . $producto->foto) }}"
                                            alt="Imagen del Libro" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">Sin imagen</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-cart-plus"></i> Agregar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    <i class="fas fa-exclamation-circle"></i> No hay libros disponibles en este momento.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        :root {
                --color-primary: #285C4D;
                --color-secondary: #B38E5D;
                --color-white: #ffffff;
        }

        .table thead {
            background-color: var(--color-primary);
            color: var(--color-white);
        }

        .precio-destacado {
            font-size: 1.25rem;
            font-weight: bold;
            color: #28a745;
        }

        .img-thumbnail {
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
            object-fit: cover;
        }

        .btn-primary {
            background-color: var(--color-secondary);
            border: none;
        }

        .btn-primary:hover {
            background-color: #966D3E;
            opacity: 0.9;
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Vista del Catálogo de Libros cargada correctamente.');
    </script>
@stop
