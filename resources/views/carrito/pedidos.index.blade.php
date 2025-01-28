@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mis Pedidos</h1>
    <table class="table table-bordered">
        <thead>
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
                    <td>{{ $pedido->total }}</td>
                    <td>{{ $pedido->created_at }}</td>
                    <td>
                        <a href="{{ route('pedido.detalles', $pedido->id) }}" class="btn btn-info">Ver Detalles</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No tienes pedidos realizados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
