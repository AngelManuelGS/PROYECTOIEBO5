@extends('adminlte::page')

@section('title', 'Mi Carrito')


@section('content')

<div class="container">
    <h1 class="text-center mb-4">Mi Carrito</h1>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
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
                        <td>{{ $item['nombre'] }}</td>
                        <td>${{ number_format($item['precio'], 2) }}</td>
                        <td>{{ $item['cantidad'] }}</td>
                        <td>${{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                        <td>
                            <form action="{{ route('carrito.remover', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">El carrito está vacío.</td>
                    </tr>
                @endforelse
            </tbody>
            @if (!empty($carrito))
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total General:</td>
                        <td colspan="2">${{ number_format($totalGeneral, 2) }}</td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
    @if (!empty($carrito))
        <form action="{{ route('carrito.comprar') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Finalizar Compra</button>
        </form>
    @endif
</div>
@endsection
