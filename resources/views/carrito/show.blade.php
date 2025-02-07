@extends('adminlte::page')

@section('title', 'Mi Carrito')

@section('content_header')
<h1 class="text-center font-weight-bold mb-2" style="color: var(--color-primary);">
    <i class="fas fa-shopping-cart"></i> Mi Carrito
    </h1>
@stop

@section('content')
<div class="container">
    <div class="card shadow-sm border-2" style="border-color: var(--color-primary); border-radius: 8px;">
        <div class="card-header bg-primary text-white d-flex align-items-center" style="border-radius: 8px 8px 0 0;">
            <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Detalles del Carrito</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="bg-dark text-white">
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
                                <td class="fw-bold">{{ $item['nombre'] }}</td>
                                <td class="text-success fw-bold">${{ number_format($item['precio'], 2) }}</td>
                                <td>
                                    <form action="{{ route('carrito.actualizar', $id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <div class="d-flex justify-content-center align-items-center">
                                            <input type="number" name="cantidad" value="{{ $item['cantidad'] }}"
                                                   min="1" max="{{ $item['stock'] }}"
                                                   class="form-control form-control-sm text-center mx-2"
                                                   style="width: 60px; font-size: 1rem; font-weight: bold;">
                                            <button type="submit" class="btn btn-info btn-sm">
                                                <i class="fas fa-sync-alt"></i> Actualizar
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td class="fw-bold text-success fs-5">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                                <td>
                                    <form action="{{ route('carrito.remover', $id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">🛒 El carrito está vacío.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if (!empty($carrito))
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total General:</td>
                                <td class="fw-bold text-success fs-4">${{ number_format($totalGeneral, 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

            @if (!empty($carrito))
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('productosVenta.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i> Seguir Comprando
                    </a>
                    <form action="{{ route('carrito.comprar') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg fw-bold">
                            <i class="fas fa-check-circle"></i> Finalizar Compra
                        </button>
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
            --color-primary: #285C4D;
            --color-secondary: #007bff;
            --color-white: #ffffff;
        }
        .btn-secondary {
    background-color: #007bff !important; /* Azul */
    border-color: #007bff !important; /* Azul */
}


        /* 🔹 Estilización del menú lateral */
        .main-sidebar {
            background-color: var(--color-primary) !important; /* Fondo del menú */
        }

        .nav-sidebar .nav-link {
            color: var(--color-white) !important;
            transition: background 0.3s ease-in-out, transform 0.2s ease-in-out;
            border-radius: 5px;
            margin: 5px;
        }

        /* Efecto hover */
        .nav-sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2) !important;
            transform: scale(1.05);
        }

        /* Íconos del menú */
        .nav-sidebar .nav-link .nav-icon {
            color: var(--color-white) !important;
        }

        /* 🔹 Color de fondo del menú activo */
        .nav-sidebar .nav-item.menu-open > .nav-link,
        .nav-sidebar .nav-link.active {
            background-color: var(--color-secondary) !important;
            color: var(--color-white) !important;
            border-radius: 5px;
        }

        /* 🔹 Ajustar la tipografía */
        .nav-sidebar .nav-link {
            font-size: 1rem;
            padding: 10px;
        }

        /* 🔹 Alinear los íconos con el texto */
        .nav-sidebar .nav-icon {
            margin-right: 8px;
        }

        /* 🔹 Botón de cierre en móviles */
        .sidebar-mini.sidebar-collapse .main-sidebar {
            width: 70px !important;
        }
        h1.text-center {
            font-size: 2.5rem; /* Ajusta el tamaño según lo necesites */
            font-weight: bold;
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
