@extends('adminlte::page')

@section('title', 'Ventas')

@section('content_header')
    <h1 style="color: var(--color-primary); font-weight: bold;">Ventas</h1>
@stop

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-sm border-2" style="border-color: var(--color-primary); border-radius: 8px;">
            <div class="card-header bg-primary text-white" style="border-radius: 8px 8px 0 0;">
                <h3 style="font-family: 'Arial', sans-serif; font-weight: bold;">Listado de Ventas</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="tblVentas" width="100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Monto Total</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .bg-primary {
            background-color: var(--color-primary) !important;
        }

        .btn-success {
            background-color: var(--color-secondary);
            color: var(--color-white);
        }

        .btn-danger {
            background-color: #dc3545;
            color: var(--color-white);
        }

        .btn-primary {
            background-color: var(--color-primary);
            color: var(--color-white);
        }

        .btn-success:hover,
        .btn-danger:hover,
        .btn-primary:hover {
            background-color: var(--color-secondary);
            opacity: 0.8; /* Efecto visual sin cambiar el color */
        }

        h1 {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            color: var(--color-primary);
        }

        .thead-dark {
            background-color: var(--color-primary);
            color: var(--color-white);
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#tblVentas').DataTable({
                responsive: true,
                fixedHeader: true,
                processing: true,
                serverSide: true,
                ajax: '{{ route('sales.list') }}',
                columns: [
                    { data: 'id' },


                    { data: 'total' },

                    { data: 'cliente_nombre', defaultContent: 'Sin cliente' },
                    {
                        data: 'created_at',
                        render: function(data) {
                            return new Date(data).toLocaleString();
                        }
                    },
                    {
                        data: 'estado',
                        render: function(data) {
                            const badgeClass = data === 'pendiente' ? 'warning' : (data === 'aprobado' ? 'success' : 'danger');
                            return `<span class="badge badge-${badgeClass}">${data}</span>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-success btn-sm" onclick="cambiarEstado(${row.id}, 'aprobado')">Aprobar</button>
                                <button class="btn btn-danger btn-sm" onclick="cambiarEstado(${row.id}, 'cancelado')">Cancelar</button>
                                <a href="/ventas/${row.id}/detalles" class="btn btn-primary btn-sm">Detalles</a>
                            `;
                        }
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                },
                order: [[0, 'desc']]
            });
        });

        function cambiarEstado(id, estado) {
            Swal.fire({
                title: `¿Estás seguro de cambiar el estado a ${estado}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/ventas/${id}/estado`, {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ estado: estado })
})

                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Error HTTP: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire('¡Actualizado!', 'El estado ha sido actualizado.', 'success');
                            $('#tblVentas').DataTable().ajax.reload(); // Recarga la tabla
                        } else {
                            Swal.fire('Error', data.error || 'No se pudo actualizar el estado.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Ocurrió un error en la solicitud.', 'error');
                    });
                }
            });
        }
    </script>
@stop
