@extends('layouts.app')

@section('content')
<div class="container">
    <h1 style="color: var(--color-primary); font-weight: bold;">Mis Pedidos</h1>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pedidos as $pedido)
                        <tr>
                            <td>{{ $pedido->id }}</td>
                            <td>${{ number_format($pedido->total, 2) }}</td>
                            <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('pedido.detalles', $pedido->id) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No tienes pedidos realizados.</td>
                        </tr>
                    @endforelse
                    @foreach ($pedidos as $pedido)
    <tr>
        <td>{{ $pedido->id }}</td>
        <td>{{ $pedido->cliente->nombre ?? 'Sin Cliente' }}</td>
        <td>{{ $pedido->usuario->name ?? 'Cliente Directo' }}</td> 
        <td>{{ $pedido->total }}</td>
        <td>{{ $pedido->estado }}</td>
    </tr>
@endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
