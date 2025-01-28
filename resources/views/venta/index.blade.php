@extends('adminlte::page')

@section('title', 'Registrar Venta')

@section('content_header')
    <h1 style="color: var(--color-primary); font-weight: bold;">Registrar Nueva Venta</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-2" style="border-color: var(--color-primary); border-radius: 8px;">
                <div class="card-header bg-primary text-white" style="border-radius: 8px 8px 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="font-family: 'Arial', sans-serif;">Registrar Venta</span>
                        <a href="{{ route('venta.show') }}" class="btn btn-secondary btn-sm">
                            Listar Ventas
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Sección para buscar cliente -->
                    <div class="row mb-3">
                        <div class="form-group col-md-4">
                            <label for="buscarCliente">Buscar Cliente</label>
                            <input id="buscarCliente" class="form-control" type="text" placeholder="Buscar Cliente">
                            <input id="id_cliente" class="form-control" type="hidden">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tel_cliente">Teléfono</label>
                            <input id="tel_cliente" class="form-control" type="text" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dir_cliente">Dirección</label>
                            <input id="dir_cliente" class="form-control" type="text" disabled>
                        </div>
                    </div>

                    <!-- Lista de productos usando Livewire -->
                    @livewire('product-list')

                    <!-- Botón para generar la venta -->
                    <div class="mt-4">
                        <button class="btn btn-success" id="btnVenta" type="button">
                            Generar Venta
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
    <style>
        .bg-primary {
            background-color: var(--color-primary) !important;
        }

        .btn-success {
            background-color: var(--color-secondary) !important;
            color: var(--color-white);
            border: none;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: var(--color-white);
            border: none;
        }

        .btn-success:hover,
        .btn-secondary:hover {
            opacity: 0.8;
        }

        h1 {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            color: var(--color-primary);
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btnVenta = document.querySelector('#btnVenta');
            const buscarCliente = document.querySelector('#buscarCliente');
            const id_cliente = document.querySelector('#id_cliente');
            const tel_cliente = document.querySelector('#tel_cliente');
            const dir_cliente = document.querySelector('#dir_cliente');

            // Configuración de autocompletado para buscar cliente
            $(buscarCliente).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('cliente.buscar') }}",
                        dataType: "json",
                        data: { term: request.term },
                        success: function(data) {
                            response(data);
                        },
                        error: function() {
                            Swal.fire('Error', 'No se pudo completar la búsqueda de clientes.', 'error');
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    id_cliente.value = ui.item.id;
                    tel_cliente.value = ui.item.telefono;
                    dir_cliente.value = ui.item.direccion;
                }
            });

            // Confirmación para generar la venta
            btnVenta.addEventListener('click', () => {
                if (!id_cliente.value) {
                    Swal.fire('Advertencia', 'Debe seleccionar un cliente para realizar la venta.', 'warning');
                    return;
                }

                Swal.fire({
                    title: "Confirmar Venta",
                    text: "¿Está seguro de procesar esta venta?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, procesar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('venta.store') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ id_cliente: id_cliente.value })
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.fire(data.title, data.message, data.icon);
                            if (data.icon === 'success') {
                                setTimeout(() => {
                                    window.open('/venta/' + data.ticket + '/ticket', '_blank');
                                    window.location.reload();
                                }, 1500);
                            }
                        })
                        .catch(error => {
                            Swal.fire('Error', 'Hubo un problema al procesar la venta.', 'error');
                        });
                    }
                });
            });
        });
    </script>
@stop
