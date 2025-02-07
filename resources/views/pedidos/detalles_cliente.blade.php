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
                <thead>
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
            <div class="d-flex justify-content-end mt-3 mb-5">
                <a href="{{ route('mis.pedidos') }}" class="btn btn-secondary">Volver a Mis Pedidos</a>

                {{-- @if ($pedido->estado == 'aprobado')  Verifica si la venta está aprobada --}}
                <a href="{{ $pedido->estado === 'aprobado' ? route('ventas.ticket', $pedido->id) : '#' }}"
                    class="btn {{ $pedido->estado === 'aprobado' ? 'btn-primary' : 'btn-secondary' }} me-2
                           {{ $pedido->estado !== 'aprobado' ? 'disabled' : '' }}"
                    id="btnImprimirRecibo"
                    {{ $pedido->estado !== 'aprobado' ? 'aria-disabled=true' : '' }}
                    target="_blank">
                     <i class="fas fa-print"></i> Imprimir Recibo
                 </a>
                {{-- @else
                    <p class="text-danger fw-bold">Esta venta aún no ha sido aprobada.</p>
                @endif --}}
            </div>

        </div>
    </div>
</div>
@endsection
