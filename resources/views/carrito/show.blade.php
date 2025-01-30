@extends('adminlte::page')

@section('title', 'Mi Carrito')

@section('content_header')
    <h1 style="color: var(--color-primary); font-weight: bold;">Mi Carrito</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-2" style="border-color: var(--color-primary); border-radius: 8px;">
            <div class="card-header bg-primary text-white" style="border-radius: 8px 8px 0 0;">
                <h5 class="mb-0">Detalles del Carrito</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Producto</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($carrito as $id => $item)
                                <tr>
                                    <td>{{ $item['nombre'] }}</td>
                                    <td>${{ number_format($item['precio'], 2) }}</td>
                                    <td>
    <form action="{{ route('carrito.actualizar', $id) }}" method="POST" class="d-inline">
        @csrf
        <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" class="form-control form-control-sm d-inline" style="width: 60px;">
        <button type="submit" class="btn btn-info btn-sm">Actualizar</button>
    </form>
</td>

                                    <td>${{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                                    <td>
                                        <form action="{{ route('carrito.remover', $id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">El carrito está vacío.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if (!empty($carrito))
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total General:</td>
                                    <td colspan="2">${{ number_format($totalGeneral, 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>

                @if (!empty($carrito))
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Seguir Comprando</a>
                        <form action="{{ route('carrito.comprar') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Finalizar Compra</button>
                        </form>
                    </div>
                @endif
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
            border: none;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: var(--color-white);
            border: none;
        }

        .btn-success:hover,
        .btn-secondary:hover {
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
        console.log('Carrito cargado correctamente.');
    </script>
@stop
