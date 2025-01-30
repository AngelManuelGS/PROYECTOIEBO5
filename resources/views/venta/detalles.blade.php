@extends('adminlte::page')

@section('title', 'Detalles de Venta')

@section('content_header')
<h1 style="color: var(--color-primary); font-weight: bold;">Detalles de Venta #{{ $venta->id }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Información General</h3>
    </div>
    <div class="card-body">
        <p><strong>Cliente:</strong> {{ $venta->cliente->nombre ?? 'Sin cliente' }}</p>
        <p><strong>Correo:</strong> {{ $venta->cliente->email ?? 'Sin correo' }}</p>
        <p><strong>Fecha de Registro del Cliente:</strong>
           {{ $venta->cliente?->created_at ? $venta->cliente->created_at->format('d/m/Y H:i:s') : 'N/A' }}</p>
        <p><strong>Fecha de Venta:</strong>
           {{ $venta->created_at ? $venta->created_at->format('d/m/Y H:i:s') : 'N/A' }}</p>
        <p><strong>Monto Total:</strong> ${{ number_format($venta->total, 2) }}</p>
        <p><strong>Estado:</strong>
            <span class="badge bg-{{ $venta->estado === 'pendiente' ? 'warning' : ($venta->estado === 'aprobado' ? 'success' : 'danger') }}">
                {{ ucfirst($venta->estado) }}
            </span>
        </p>
    </div>
</div>

@if($venta->detalleventa->isNotEmpty())
<div class="card mt-4">
    <div class="card-header">
        <h3>Productos Vendidos</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->detalleventa as $detalle)
                    <tr>
                        <td>{{ $detalle->producto->nombre ?? 'Sin nombre' }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>${{ number_format($detalle->precio, 2) }}</td>
                        <td>${{ number_format($detalle->cantidad * $detalle->precio, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="mt-4 text-end">
    <a href="{{ route('ventas.ticket', $venta->id) }}" target="_blank" class="btn btn-primary">
        Imprimir Recibo
    </a>
    <form action="{{ route('ventas.eliminar', $venta->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta venta?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Eliminar</button>
    </form>
</div>
@stop
