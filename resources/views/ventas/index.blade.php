@extends('adminlte::page')

@section('content')
<h1>Ventas Realizadas</h1>
<table>
    <thead class="thead-dark">
        <tr>
            <th>Cliente</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Detalles</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($ventas as $venta)
            <tr>
                <td>{{ $venta->cliente->name }}</td>
                <td>${{ $venta->total }}</td>
                <td>{{ $venta->created_at }}</td>
                <td>
                    <ul>
                        @foreach ($venta->detalleventa as $detalle)
                            <li>{{ $detalle->producto->nombre }} - ${{ $detalle->precio_unitario }} x {{ $detalle->cantidad }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
