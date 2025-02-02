@extends('adminlte::page')

@section('title', 'Detalles de Venta')

@section('content_header')
    <h1 class="text-center" style="color: var(--color-primary); font-weight: bold;">
        Detalles de Venta #{{ $venta->id }}
    </h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Información General</h3>
    </div>
    <div class="card-body">
        <p><strong>Cliente:</strong> {{ $venta->cliente->name ?? 'Sin cliente' }}</p>
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

        @if ($venta->detalleventa->isNotEmpty())
            <!-- Tarjeta de Productos Vendidos -->
            <div class="card mt-4 shadow-sm border-2">
                <div class="card-header bg-success text-white" style="border-radius: 8px 8px 0 0;">
                    <h5 class="mb-0">Productos Vendidos</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="bg-secondary text-white">
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
                                    <td>{{ $detalle->producto->nombre ?? 'Productos' }}</td>
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

        <!-- Botones de Acción -->
        <div class="d-flex justify-content-end mt-3 mb-5">
            <a href="{{ route('ventas.ticket', $venta->id) }}" target="_blank" class="btn btn-primary me-2">
                <i class="fas fa-print"></i> Imprimir Recibo
            </a>
            <button type="button" class="btn btn-danger" id="btnEliminarVenta" data-id="{{ $venta->id }}">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </div>

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        :root {
            --color-primary: #285C4D;
            --color-secondary: #B38E5D;
            --color-white: #ffffff;
        }

        .bg-primary {
            background-color: var(--color-primary) !important;
        }

        .bg-success {
            background-color: #285C4D !important;
        }

        .table thead {
            background-color: var(--color-primary);
            color: var(--color-white);
        }

        .btn-primary,
        .btn-danger {
            border: none;
            color: white;
        }

        .btn-primary:hover,
        .btn-danger:hover {
            opacity: 0.8;
        }

        /* Espaciado para que los botones no queden pegados a la parte de abajo */
        .mt-5 {
            margin-top: 5rem !important;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('btnEliminarVenta').addEventListener('click', function() {
                let ventaId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Eliminar Venta',
                    text: "¿Estás seguro de que quieres eliminar esta venta?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/ventas/${ventaId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Eliminado',
                                            'La venta ha sido eliminada con éxito.', 'success')
                                        .then(() => window.location.href = '/ventas');
                                } else {
                                    Swal.fire('Error', 'No se pudo eliminar la venta.',
                                    'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire('Error', 'Ocurrió un problema al eliminar la venta.',
                                    'error');
                            });
                    }
                });
            });
        });
    </script>
@stop
