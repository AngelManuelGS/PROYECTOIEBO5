@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 style="color: var(--color-primary); font-weight: bold;">Panel de Control</h1>
@stop

@section('content')
    <div class="row">
        <!-- Cajas informativas con estadísticas -->
        @php
            $labels = [
                'clients' => 'Clientes',
                'products' => 'Productos',
                'categories' => 'Categorías',
                'sales' => 'Ventas',
            ];
        @endphp
        @foreach ($totales as $key => $value)
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-{{ $key == 'clients' ? 'success' : ($key == 'products' ? 'primary' : ($key == 'categories' ? 'warning' : 'info')) }}">
                        <i class="fas fa-{{ $key == 'clients' ? 'users' : ($key == 'products' ? 'list' : ($key == 'categories' ? 'tags' : 'cash-register')) }}"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">{{ $labels[$key] }}</span>
                        <span class="info-box-number">{{ $value }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <!-- Gráficos de ventas -->
        <div class="col-md-6">
            <div class="card shadow-sm border-2" style="border-color: var(--color-primary);">
                <div class="card-header bg-primary text-white" style="border-radius: 8px 8px 0 0;">
                    <h3 class="card-title">Ventas por Semana</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="ventasPorSemana"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-2" style="border-color: var(--color-primary);">
                <div class="card-header bg-primary text-white" style="border-radius: 8px 8px 0 0;">
                    <h3 class="card-title">Ventas por Mes</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="ventasPorMes"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .info-box-icon {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        h1 {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            color: var(--color-primary);
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            ventasSemana();
            ventasMes();
        });

        // Ventas por Semana
        function ventasSemana() {
            const ctx = document.getElementById('ventasPorSemana').getContext('2d');
            const data = {!! json_encode($ventasPorSemana) !!};
            const labels = data.map(item => item.dia);
            const valores = data.map(item => item.total);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Ventas por Día',
                        data: valores,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                    }],
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        }

        // Ventas por Mes
        function ventasMes() {
            const ctx = document.getElementById('ventasPorMes').getContext('2d');
            const dataVenta = @json($ventas);

            if (dataVenta && Object.keys(dataVenta).length > 0) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(dataVenta[Object.keys(dataVenta)[0]]),
                        datasets: Object.keys(dataVenta).map(year => ({
                            label: `Año ${year}`,
                            data: Object.values(dataVenta[year]),
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                        })),
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                            },
                        },
                    },
                });
            }
        }
    </script>
@stop
