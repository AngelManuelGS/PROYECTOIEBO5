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

            <a href="{{ route('mis.pedidos') }}" class="btn btn-secondary">Volver a Mis Pedidos</a>
        </div>
    </div>
</div>
@endsection
