<!DOCTYPE html>
<html>
<head>
    <title>Reporte ticket</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            position: relative;
        }

        .background {
            position: absolute;
            top: 0;
            left: 30px; /* Más separada del margen izquierdo */
            height: 100%;
            width: 170px; /* Imagen más delgada */
        }

        .content {
            position: relative;
            margin-left: 190px; /* Ajusta el contenido un poco a la izquierda pero dejando espacio */
            padding: 10px;
        }

        .business-info {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
            font-size: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .total {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <!-- Fondo con el marco -->
    <div class="background">
        <img src="{{ public_path('img/Marco2.png') }}" alt="Marco izquierdo">
    </div>

    <!-- Contenido del ticket -->
    <div class="content">
        <div class="business-info">
            <h3>{{ $company['nombre'] }}</h3>
            <p>{{ $company['direccion'] }}</p>
            <p>Tel: {{ $company['telefono'] }}</p>
        </div>
        <div class="divider"></div>
        <p><strong>Fecha:</strong> {{ $fecha }}</p>
        <p><strong>Hora:</strong> {{ $hora }}</p>
        <p><strong>Venta ID:</strong> #{{ $venta->id }}</p>
        <div class="divider"></div>
        <p><strong>Cliente:</strong> {{ $venta->cliente->name ?? 'Sin cliente' }}</p>
        <p><strong>Teléfono:</strong> {{ $venta->cliente->telefono ?? 'N/A' }}</p>
        <p><strong>Dirección:</strong> {{ $venta->cliente->direccion ?? 'N/A' }}</p>
        <div class="divider"></div>

        <table>
            <thead>
                <tr>
                    <th>Cant</th>
                    <th>Producto</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->cantidad }}</td>
                        <td>{{ $producto->producto->producto ?? 'Producto eliminado' }}</td>
                        <td>${{ number_format($producto->precio, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">Total: ${{ number_format($venta->total, 2) }}</p>
    </div>
</body>
</html>
