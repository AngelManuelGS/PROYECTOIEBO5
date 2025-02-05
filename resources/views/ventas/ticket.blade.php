<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Pedido</title>
    <style>
        @page {
            size: letter; /* Tamaño carta */
            margin: 0; /* Márgenes */
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .background img {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%; /* Que abarque toda la altura de la página */
            width: auto; /* Mantener las proporciones */
        }

        .content {
            position: relative; /* Asegura que el contenido no se superponga al fondo */
            margin-left: 120px; /* Espacio para que el contenido no toque el diseño */
            padding: 20px;
        }

        .text-center {
            text-align: center;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            font-size: 12px;
            text-align: left;
            padding: 5px;
            border: 1px solid #ddd;
        }

        th {
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .total {
            font-size: 14px;
            font-weight: bold;
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Fondo -->
    <div class="background">
        <img src="{{ public_path('img/Marco2.png') }}" alt="Marco Izquierdo">
    </div>

    <!-- Contenido -->
    <div class="content">
        <div class="text-center">
            <h2>{{ $company['nombre'] }}</h2>
            <p>{{ $company['direccion'] }}</p>
            <p>Tel: {{ $company['telefono'] }}</p>
        </div>

        <div class="divider"></div>
        <p><strong>Fecha:</strong> {{ $fecha }}</p>
        <p><strong>Hora:</strong> {{ $hora }}</p>
        <p><strong>Venta ID:</strong> #{{ $venta->id }}</p>
        <div class="divider"></div>
        <p><strong>Director:</strong> {{ $venta->cliente->nombre ?? 'Sin cliente' }}</p>
        <p><strong>Teléfono:</strong> {{ $venta->cliente->telefono ?? 'N/A' }}</p>
        <p><strong>Dirección:</strong> {{ $venta->cliente->direccion ?? 'N/A' }}</p>
        <div class="divider"></div>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->producto->producto ?? 'Producto' }}</td>
                        <td>{{ $producto->cantidad }}</td>
                        <td>${{ number_format($producto->precio, 2) }}</td>
                        <td>${{ number_format($producto->cantidad * $producto->precio, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="divider"></div>
        <p class="total">Total: ${{ number_format($productos->sum(fn($producto) => $producto->cantidad * $producto->precio), 2) }}</p>
        <div class="footer">
            <p>¡Gracias por su compra!</p>
        </div>
    </div>
</body>
</html>
