@extends('adminlte::page') <!-- Extiende la plantilla AdminLTE para la estructura de la página -->

@section('title', 'Clientes') <!-- Define el título de la página como "Clientes" -->

@section('content_header')
    <h1 style="color: var(--color-primary); font-weight: bold;">Clientes</h1> <!-- Encabezado principal de la sección de "Clientes" -->
@stop

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm" style="border: 2px solid var(--color-primary); border-radius: 8px;">
            <div class="card-header" style="background-color: var(--color-primary); color: var(--color-white); border-radius: 8px 8px 0 0;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <!-- Título de la tarjeta -->
                    <span style="font-family: 'Arial', sans-serif; font-size: 1.2rem; font-weight: bold;" id="card_title">
                        {{ __('Clientes') }}
                    </span>
                    <div class="float-right">
                        <!-- Botón para crear un nuevo cliente -->
                        <a href="{{ route('clientes.create') }}" class="btn btn-sm" style="background-color: var(--color-secondary); color: var(--color-white);">
                            {{ __('Crear Nuevo') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Mensaje de éxito -->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <!-- Tabla para mostrar los clientes -->
                    <table class="table table-striped table-hover display nowrap" width="100%"
                           id="tblClients" style="border: 1px solid var(--color-primary);">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo Electrónico</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Plante Educativo</th>
                                <th>Región</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <!-- Estilos CSS específicos para la vista personalizada -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        :root {
            --color-primary: #285C4D;
            --color-secondary: #B38E5D;
            --color-white: #ffffff;
        }

        body {
            font-family: 'Arial', sans-serif;
        }

        .btn-primary {
            background-color: var(--color-primary);
            border: none;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .thead-dark {
            background-color: var(--color-primary);
            color: var(--color-white);
        }

        .dataTables_length {
            float: left;
        }

        .dataTables_filter {
            float: right;
        }

        .dataTables_paginate {
            float: right;
        }

        .dataTables_info {
            float: left;
            margin-top: 10px;
        }
    </style>
@stop

@section('js')
    <!-- Scripts para DataTables y SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $('#tblClients').DataTable({
                responsive: true,
                fixedHeader: true,
                ajax: '{{ route('clients.list') }}', // Ruta para obtener los datos del JSON
                columns: [
                    { data: 'id', title: 'ID' },
                    { data: 'nombre', title: 'Nombre' },
                    { data: 'email', title: 'Correo Electrónico', defaultContent: 'Sin correo' },
                    { data: 'telefono', title: 'Teléfono' },
                    { data: 'direccion', title: 'Dirección' },
                    { data: 'plante_educativo', title: 'Plante Educativo', defaultContent: 'No especificado' },
                    { data: 'region', title: 'Región', defaultContent: 'No especificado' },
                    {
                        data: null,
                        title: 'Acciones',
                        orderable: false,
                        render: function (data, type, row) {
                            return `
                                <a href="/clientes/${row.id}/edit" class="btn btn-sm btn-primary">Editar</a>
                                <button class="btn btn-sm btn-danger" onclick="deleteClient(${row.id})">Eliminar</button>
                            `;
                        }
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                },
                order: [[0, 'desc']],
                dom: 'lfrtip',
            });
        });

        function deleteClient(clientId) {
            Swal.fire({
                title: "Eliminar",
                text: "¿Estás seguro de que quieres eliminar este cliente?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Sí, eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/clientes/${clientId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Eliminado", "El cliente ha sido eliminado.", "success");
                                $('#tblClients').DataTable().ajax.reload();
                            } else {
                                Swal.fire("Error", "No se pudo eliminar el cliente.", "error");
                            }
                        })
                        .catch(error => {
                            Swal.fire("Error", "Hubo un problema al eliminar el cliente.", "error");
                            console.error(error);
                        });
                }
            });
        }
    </script>
@stop
