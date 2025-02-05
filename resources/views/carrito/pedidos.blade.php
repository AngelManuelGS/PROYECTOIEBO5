@extends('adminlte::page')

@section('title', 'Mis Pedidos')

@section('content')
<div class="container">
    <h1 class="text-center font-weight-bold mb-2" style="color: var(--color-primary);">
        <i class="fas fa-shopping-cart"></i> Mis Pedidos
    </h1>

    <div class="card shadow-sm border-2 mb-4" style="border-radius: 8px; border-color: var(--color-primary);">
        <div class="card-body">
            <!-- 📌 Primera Tabla: Compras del CLIENTE -->
            <h3 class="text-center text-white p-2 rounded" style="background-color: var(--color-primary); font-weight: bold;">
                <i class="fas fa-shopping-bag"></i> Mis Compras
            </h3>
            <table class="table table-bordered table-hover text-center">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ventasCliente as $pedido)
                        <tr>
                            <td>{{ $pedido->id }}</td>
                            <td class="precio-grande">${{ number_format($pedido->total, 2) }}</td>
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
                                <a href="{{ route('pedidos.cliente.detalles', $pedido->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Ver Detalles
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No tienes compras realizadas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- 📌 Segunda Tabla: Ventas realizadas por un ADMINISTRADOR -->
            <h3 class="text-center text-white p-2 rounded mt-4" style="background-color: var(--color-success); font-weight: bold;">
                <i class="fas fa-user-tie"></i> Ventas realizadas por un Administrador
            </h3>
            <table class="table table-bordered table-hover text-center">
                <thead class="bg-secondary text-white">
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
                    @forelse ($ventasAdmin as $pedido)
                        <tr>
                            <td>{{ $pedido->id }}</td>
                            <td class="precio-grande">${{ number_format($pedido->total, 2) }}</td>
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
                                <a href="{{ route('pedidos.cliente.detalles', $pedido->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Ver Detalles
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No tienes ventas realizadas por un administrador.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        :root {
            --color-primary: #285C4D;
            --color-success: #28a745;
            --color-secondary: #B38E5D;
            --color-white: #ffffff;
        }

        .table thead {
            background-color: var(--color-primary);
            color: var(--color-white);
        }

        .precio-grande {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .btn-info {
            background-color: #17a2b8;
            border: none;
        }

        .btn-info:hover {
            background-color: #138496;
            opacity: 0.9;
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Vista de mis pedidos cargada correctamente.');
    </script>
@stop
