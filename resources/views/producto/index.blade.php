@extends('adminlte::page') <!-- Extiende la plantilla AdminLTE -->

@section('title', 'Libros') <!-- Define un título descriptivo -->

@section('content_header')
    <!-- Encabezado principal con estilo consistente -->
    <h1 style="color: var(--color-primary); font-weight: bold;">Listado de Libros</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-2" style="border-color: var(--color-primary); border-radius: 8px;">
                <div class="card-header bg-primary text-white" style="border-radius: 8px 8px 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="font-family: 'Arial', sans-serif;">Libros</span>
                        <a href="{{ route('productos.create') }}" class="btn btn-success btn-sm">
                            Crear Nuevo
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Mostrar mensaje de éxito si existe -->
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Tabla de libros -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover display responsive nowrap" width="100%" id="tblProducts">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Código</th>
                                    <th>Libro</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
    <link href="DataTables/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .bg-primary {
            background-color: var(--color-primary) !important;
        }

        .btn-success {
            background-color: var(--color-secondary);
            color: var(--color-white);
        }

        .btn-success:hover {
            background-color: var(--color-secondary) !important; /* Mantiene el mismo color */
            color: var(--color-white) !important; /* Mantiene el texto blanco */
        }

        .btn-danger {
            background-color: #dc3545;
            color: var(--color-white);
        }

        .btn-danger:hover {
            background-color: #dc3545 !important; /* Mantiene el color rojo */
            color: var(--color-white) !important;
        }

        .btn-primary {
            background-color: #007bff;
            color: var(--color-white);
        }

        .btn-primary:hover {
            background-color: #007bff !important; /* Mantiene el color azul */
            color: var(--color-white) !important;
        }

        h1 {
            font-family: 'Arial', sans-serif; /* Fuente consistente */
            font-weight: bold;
            color: var(--color-primary);
        }
    </style>
@s
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="DataTables/datatables.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Inicializar DataTable
            new DataTable('#tblProducts', {
                responsive: true,
                fixedHeader: true,
                ajax: {
                    url: '{{ route('products.list') }}',
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'id' },
                    { data: 'codigo' },
                    { data: 'producto' },
                    { data: 'precio_compra' },
                    { data: 'precio_venta' },
                    {
                        data: 'foto',
                        render: function(data, type, row) {
                            return data ? '<img src="storage/' + data +
                                '" alt="Imagen del Producto" style="max-width: 100px; max-height: 100px;">' :
                                'Sin imagen';
                        },


                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <a href="/productos/${row.id}/edit" class="btn btn-sm btn-primary">Editar</a>
                                <button class="btn btn-sm btn-danger" onclick="deleteProduct(${row.id})">Eliminar</button>
                            `;
                        }
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                },
                order: [[0, 'desc']] // Ordena por ID descendente
            });
        });

        // Función para eliminar un libro
        function deleteProduct(productId) {
            Swal.fire({
                title: "Eliminar",
                text: "¿Estás seguro de que quieres eliminar este libro?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Sí, eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/productos/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        $('#tblProducts').DataTable().ajax.reload(); // Recarga la tabla
                    })
                    .catch(error => {
                        console.error('Error al eliminar el libro:', error);
                    });
                }
            });
        }
    </script>
@stop
