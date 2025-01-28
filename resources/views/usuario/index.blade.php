@extends('adminlte::page')
<!-- Extiende la plantilla de AdminLTE para proporcionar estructura y estilos básicos de panel de administración -->

@section('title', 'Usuarios')
<!-- Define el título de la página como "Usuarios" -->

@section('content_header')
    <h1>Usuarios</h1>
    <!-- Encabezado de la página que muestra "Usuarios" -->
@stop

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm" style="border: 2px solid var(--color-primary); border-radius: 8px;">
            <div class="card-header" style="background-color: var(--color-primary); color: var(--color-white); border-radius: 8px 8px 0 0;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span id="card_title">
                        {{ __('Usuarios') }}
                    </span>
                    <div class="float-right">
                        <a href="{{ route('usuarios.create') }}" class="btn btn-sm" style="background-color: var(--color-secondary); color: var(--color-white);">
                            {{ __('Crear Nuevo') }}
                        </a>
                        <!-- Botón para agregar un nuevo usuario, redirige a la vista de creación -->
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <!-- Muestra un mensaje de éxito si existe en la sesión -->
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-hover display nowrap" width="100%" id="tblUsers" style="width: 100%; max-width: 95%; margin: auto; border: 1px solid var(--color-primary); font-size: 0.9rem;">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width: 10%;">Id</th>
                                <th style="width: 30%;">Nombre</th>
                                <th style="width: 40%;">Correo</th>
                                <th style="width: 20%;">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                    <!-- Tabla de usuarios utilizando DataTables para mostrar datos dinámicamente -->
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="DataTables/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- Incluye archivos CSS de DataTables y un archivo personalizado -->
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
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="DataTables/datatables.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new DataTable('#tblUsers', {
                responsive: true,
                fixedHeader: true,
                ajax: {
                    url: '{{ route('users.list') }}',
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'email' },
                    {
                        // Columna de acciones con botones de edición y eliminación
                        data: null,
                        render: function (data, type, row) {
                            return `
                                <a class="btn btn-sm btn-primary" href="/usuarios/${row.id}/edit">Editar</a>
                                <button class="btn btn-sm btn-danger" onclick="deleteUser(${row.id})">Eliminar</button>
                            `;
                        }
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                },
                order: [[0, 'desc']]
                // Ordena la tabla por ID en orden descendente
            });
        });

        // Función para eliminar un usuario
        function deleteUser(userId) {
            Swal.fire({
                title: "Eliminar",
                text: "¿Estás seguro de que quieres eliminar este usuario?",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/usuarios/' + userId, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            return response.text();
                        })
                        .then(data => {
                            // Recarga la tabla para actualizar la lista después de eliminar un usuario
                            $('#tblUsers').DataTable().ajax.reload();
                        })
                        .catch(error => {
                            // Maneja errores en la eliminación
                            console.error('Error al eliminar:', error);
                        });
                }
            });
        }
    </script>
@stop
