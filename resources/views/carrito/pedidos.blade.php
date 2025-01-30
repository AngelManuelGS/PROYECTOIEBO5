@extends('adminlte::page')

@section('content')
<div class="container">
    <h1 style="color: var(--color-primary); font-weight: bold;">Mis Pedidos</h1>

    <div class="card">
        <div class="card-body">
            {{-- 📌 Primera Tabla: Ventas realizadas por el CLIENTE --}}
            <h3 class="text-center" style="color: var(--color-primary);">Mis Compras</h3>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($ventasCliente->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">No tienes compras realizadas.</td>
                        </tr>
                    @else
                        @foreach ($ventasCliente as $pedido)
                            <tr>
                                <td>{{ $pedido->id }}</td>
                                <td>${{ number_format($pedido->total, 2) }}</td>
                                <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge 
                                        @if ($pedido->estado === 'pendiente') bg-warning
                                        @elseif ($pedido->estado === 'aprobado') bg-success
                                        @else bg-danger @endif">
                                        {{ ucfirst($pedido->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('pedidos.cliente.detalles', $pedido->id) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{-- 📌 Segunda Tabla: Ventas realizadas por un ADMINISTRADOR --}}
            <h3 class="text-center mt-4" style="color: var(--color-primary);">Ventas realizadas por un Administrador</h3>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Administrador</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($ventasAdmin->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No tienes ventas realizadas por un administrador.</td>
                        </tr>
                    @else
                        @foreach ($ventasAdmin as $pedido)
                            <tr>
                                <td>{{ $pedido->id }}</td>
                                <td>${{ number_format($pedido->total, 2) }}</td>
                                <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $pedido->usuario->name ?? 'Administrador Desconocido' }}</td>

                                <td>
                                    <span class="badge 
                                        @if ($pedido->estado === 'pendiente') bg-warning
                                        @elseif ($pedido->estado === 'aprobado') bg-success
                                        @else bg-danger @endif">
                                        {{ ucfirst($pedido->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('pedidos.cliente.detalles', $pedido->id) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
