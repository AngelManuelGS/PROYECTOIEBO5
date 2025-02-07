@extends('adminlte::page')

@section('content')
<div class="container">
    <h1 style="color: var(--color-primary); font-weight: bold;">Detalles de Mi Pedido</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>ID de Pedido:</strong> {{ $pedido->id }}</p>
            <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Total:</strong> ${{ number_format($pedido->total, 2) }}</p>

            <h4>Productos:</h4>
            <table class="table table-bordered">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedido->detalleventa as $detalle)
                        <tr>
                            <td>{{ $detalle->producto->producto }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>${{ number_format($detalle->precio, 2) }}</td>
                            <td>${{ number_format($detalle->cantidad * $detalle->precio, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between mt-3 mb-5">
                <!-- Botón Volver a Mis Pedidos, a la izquierda -->
                <a href="{{ route('mis.pedidos') }}" class="btn btn-secondary">Volver a Mis Pedidos</a>

                <!-- Botón Imprimir Recibo, a la derecha -->
                <a href="{{ $pedido->estado === 'aprobado' ? route('ventas.ticket', $pedido->id) : '#' }}"
                    class="btn {{ $pedido->estado === 'aprobado' ? 'btn-primary' : 'btn-secondary' }} me-2
                           {{ $pedido->estado !== 'aprobado' ? 'disabled' : '' }}"
                    id="btnImprimirRecibo"
                    {{ $pedido->estado !== 'aprobado' ? 'aria-disabled=true' : '' }}
                    target="_blank">
                     <i class="fas fa-print"></i> Imprimir Recibo
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

@section('css')
    <style>
        :root {
            --color-primary: #285C4D; /* Verde */
            --color-secondary: #007bff; /* Azul */
            --color-white: #ffffff;
        }

        .bg-primary {
            background-color: var(--color-primary) !important;
        }

        .btn-primary {
            border-color: var(--color-primary);
        }

            .btn-secondary {
                background-color: var(--color-primary);
                color: var(--color-white);
            }

            .btn-primary:hover {
    border-color: var(--color-primary) !important;
}

            .btn-secondary:hover {
                background-color: var(--color-primary);
            }

        .d-flex {
            display: flex;
            justify-content: space-between; /* Los botones estarán separados entre izquierda y derecha */
        }
        .main-sidebar {
    background-color: var(--color-primary) !important;
}

    </style>
@stop
