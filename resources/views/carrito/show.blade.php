@extends('adminlte::page')

@section('title', 'Mi Carrito')

@section('content_header')
    <h1 style="color: var(--color-primary); font-weight: bold;">Mi Carrito</h1>
@stop

@section('content')
<div class="container">
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
                                <td>
    <form action="{{ route('carrito.actualizar', $id) }}" method="POST" class="d-inline">
        @csrf
        <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" 
       min="1" max="{{ $item['stock'] }}" 
       class="form-control form-control-sm d-inline" style="width: 60px;">

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
                    <a href="{{ route('productosVenta.index') }}" class="btn btn-secondary">Seguir Comprando</a>
                    <form action="{{ route('carrito.comprar') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Finalizar Compra</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        :root {
            --color-primary: #285C4D; /* Verde más claro, igual al catálogo */
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

        .btn-secondary {
            background-color: #6c757d;
            color: var(--color-white);
            border: none;
        }

        .btn-danger {
            background-color: #dc3545;
            color: var(--color-white);
            border: none;
        }

        .btn:hover {
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
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input[name="cantidad"]').forEach(input => {
        input.addEventListener('change', function () {
            let maxStock = parseInt(this.getAttribute('max'));
            if (parseInt(this.value) > maxStock) {
                alert('No puedes agregar más de ' + maxStock + ' unidades.');
                this.value = maxStock; // Ajusta automáticamente al máximo permitido
            }
        });
    });
});
</script>

@stop
