@extends('adminlte::page')

@section('title', 'Dashboard') <!-- Define el título de la página como "Dashboard" -->

@section('content_header')
    <h1>Categorías</h1> <!-- Encabezado principal de la sección de categorías -->
@stop

@section('content')
    <div class="container-fluid">
         <div class="card shadow-sm" style="border: 2px solid var(--color-primary);">

                <div class="card-header" style="background-color: var(--color-primary); color: var(--color-white);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <!-- Título de la tarjeta -->
                        <span id="card_title">
                            {{ __('Categorías') }}
                        </span>
                        <div class="float-right">
                            <!-- Botón para crear una nueva categoría, que enlaza a la vista de creación -->
                            <a href="{{ route('categorias.create') }}" class="btn btn-sm btn-light" style="background-color: var(--color-secondary); color: var(--color-white);">

                                {{ __('Crear Nueva') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Mensaje de éxito tras realizar una acción, como la creación o eliminación -->
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <!-- Tabla para mostrar las categorías con estilo responsivo -->
                        <table class="table table-striped table-hover display responsive nowrap" width="100%"
                            id="tblCategories " style="width: 100%; border: 1px solid var(--color-primary);" >
                            <thead class="thead-dark">
                                <tr>
                                    <th>Id</th> <!-- Columna para ID de la categoría -->
                                    <th>Nombre</th> <!-- Columna para el nombre de la categoría -->
                                    <th>Año</th> <!-- Columna para el año -->
                                    <th>Ciclo Escolar</th> <!-- Columna para el ciclo escolar -->
                                    <th>Acciones</th> <!-- Columna para botones de acciones -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categorias as $categoria)
                                    <tr>
                                        <td>{{ $categoria->id }}</td>
                                        <td>{{ $categoria->nombre }}</td>
                                        <td>{{ $categoria->anio }}</td>
                                        <td>{{ $categoria->ciclo }}</td>
                                        <td>
                                            <!-- Botones de acciones: Editar y Eliminar -->
                                            <a class="btn btn-sm btn-primary"
                                               href="{{ route('categorias.edit', $categoria->id) }}">Editar</a>
                                            <button class="btn btn-sm btn-danger"
                                                    onclick="deleteCategory({{ $categoria->id }})">Eliminar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <!-- Estilos CSS para DataTables y estilos personalizados -->
    <link href="DataTables/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('js')
    <!-- Scripts necesarios: SweetAlert2 y DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="DataTables/datatables.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Inicializa la tabla con DataTables
            $('#tblCategories').DataTable({
                responsive: true,
                fixedHeader: true,
                order: [[0, 'desc']], // Ordena por ID en orden descendente
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json', // Traducción al español
                },
            });
        });

        // Función para eliminar una categoría utilizando SweetAlert2
        function deleteCategory(categoryId) {
            Swal.fire({
                title: "Eliminar",
                text: "¿Estás seguro de que quieres eliminar esta categoría?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Sí, eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Solicitud DELETE para eliminar la categoría
                    fetch('/categorias/' + categoryId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                    }).then(response => response.json())
                      .then(data => {
                          if (data.success) {
                              location.reload(); // Recarga la página tras eliminar
                          } else {
                              Swal.fire("Error", "No se pudo eliminar la categoría", "error");
                          }
                      }).catch(error => {
                          console.error("Error al eliminar:", error);
                      });
                }
            });
        }
    </script>
@stop
