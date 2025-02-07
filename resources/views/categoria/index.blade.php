@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 style="color: var(--color-primary); font-weight: bold;">Categorías</h1>
@stop

@section('content')
    <div class="container-fluid">
         <div class="card shadow-sm" style="border: 2px solid var(--color-primary);">
                <div class="card-header" style="background-color: var(--color-primary); color: var(--color-white);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-family: 'Arial', sans-serif; font-size: 1.2rem; font-weight: bold;" id="card_title">
                            {{ __('Categorías') }}
                        </span>
                        <div class="float-right">
                            <a href="{{ route('categorias.create') }}" class="btn btn-sm btn-light"
                               style="background-color: var(--color-secondary); color: var(--color-white);">
                                {{ __('Crear Nueva') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-hover display responsive nowrap" width="100%"
                            id="tblCategories" style="width: 100%; border: 1px solid var(--color-primary);">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Año</th>
                                    <th>Ciclo Escolar</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categorias as $categoria)
                                    <tr id="categoria-{{ $categoria->id }}">
                                        <td>{{ $categoria->id }}</td>
                                        <td>{{ $categoria->nombre }}</td>
                                        <td>{{ $categoria->anio }}</td>
                                        <td>{{ $categoria->ciclo }}</td>
                                        <td>
                                            <a class="btn btn-sm"
                                            href="{{ route('categorias.edit', $categoria->id) }}"
                                            style="background-color: #285C4D; color: white; transition: background-color 0.3s;"
                                            onmouseover="this.style.backgroundColor='#007bff';"
                                            onmouseout="this.style.backgroundColor='#285C4D';">Editar</a>
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
@stop

@section('css')
    <link href="DataTables/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="DataTables/datatables.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let table = $('#tblCategories').DataTable({
                responsive: true,
                fixedHeader: true,
                order: [[0, 'desc']],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                },
            });

            window.deleteCategory = function (categoryId) {
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
                        fetch(`/categorias/${categoryId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Eliminar la fila sin recargar
                                table.row(`#categoria-${categoryId}`).remove().draw();

                                Swal.fire({
                                    title: "Eliminado",
                                    text: "Categoría eliminada exitosamente",
                                    icon: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire("Error", "No se pudo eliminar la categoría", "error");
                            }
                        }).catch(error => {
                            console.error("Error al eliminar:", error);
                            Swal.fire("Error", "Hubo un problema con la eliminación", "error");
                        });
                    }
                });
            };
        });
    </script>
@stop
