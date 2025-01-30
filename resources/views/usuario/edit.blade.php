@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1 class="text-center" style="color: var(--color-primary); font-weight: bold;">Editar Usuario</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Mostrar errores si existen -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm border-2 border-primary rounded-lg">
                <div class="card-header bg-primary text-white rounded-top">
                    <h5 class="mb-0">Formulario de Edición de Usuario</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}" role="form">
                        @csrf
                        @method('PUT') <!-- Cambiado de PATCH a PUT -->

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $usuario->name) }}"
                                   class="form-control @error('name') is-invalid @enderror" placeholder="Nombre completo" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $usuario->email) }}"
                                   class="form-control @error('email') is-invalid @enderror" placeholder="Correo electrónico" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Dejar vacío si no desea cambiarla">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Rol -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="admin" {{ old('role', $usuario->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="cliente" {{ old('role', $usuario->role) == 'cliente' ? 'selected' : '' }}>Cliente</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campos adicionales para Cliente -->
                        <div id="campos-cliente" style="display: none;">
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror"
                                       placeholder="Ingrese el número de teléfono" value="{{ old('telefono', $usuario->cliente->telefono ?? '') }}" required>
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" name="direccion" id="direccion" class="form-control @error('direccion') is-invalid @enderror"
                                       placeholder="Ingrese la dirección" value="{{ old('direccion', $usuario->cliente->direccion ?? '') }}" required>
                                @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="plantel_educativo" class="form-label">Plantel Educativo</label>
                                <input type="text" name="plantel_educativo" id="plantel_educativo" class="form-control @error('plantel_educativo') is-invalid @enderror"
                                       placeholder="Ingrese el plantel educativo" value="{{ old('plantel_educativo', $usuario->cliente->plantel_educativo ?? '') }}" required>
                                @error('plantel_educativo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="region" class="form-label">Región</label>
                                <input type="text" name="region" id="region" class="form-control @error('region') is-invalid @enderror"
                                       placeholder="Ingrese la región" value="{{ old('region', $usuario->cliente->region ?? '') }}" required>
                                @error('region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="mt-3 d-flex justify-content-between">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-success">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .bg-primary {
            background-color: var(--color-primary) !important;
        }

        .btn-success {
            background-color: var(--color-secondary);
        }

        .btn-danger {
            background-color: #dc3545;
            color: var(--color-white);
        }

        .btn-success:hover,
        .btn-danger:hover {
            opacity: 0.8;
        }
    </style>
@stop

@section('js')
    <script>
       document.addEventListener("DOMContentLoaded", function () {
    let roleSelect = document.getElementById("role");
    let form = document.querySelector("form");

    function toggleCamposCliente() {
        let camposCliente = document.getElementById("campos-cliente");

        if (roleSelect.value === "cliente") {
            camposCliente.style.display = "block";
            document.getElementById("telefono").setAttribute("required", "required");
            document.getElementById("direccion").setAttribute("required", "required");
            document.getElementById("plantel_educativo").setAttribute("required", "required");
            document.getElementById("region").setAttribute("required", "required");
        } else {
            camposCliente.style.display = "none";
            document.getElementById("telefono").removeAttribute("required");
            document.getElementById("direccion").removeAttribute("required");
            document.getElementById("plantel_educativo").removeAttribute("required");
            document.getElementById("region").removeAttribute("required");
        }
    }

    roleSelect.addEventListener("change", toggleCamposCliente);
    toggleCamposCliente();

    form.addEventListener("submit", function (e) {
        if (roleSelect.value === "cliente") {
            let campos = ["telefono", "direccion", "plantel_educativo", "region"];
            let valid = true;

            campos.forEach(id => {
                let campo = document.getElementById(id);
                if (campo.value.trim() === '') {
                    campo.classList.add("is-invalid");
                    valid = false;
                } else {
                    campo.classList.remove("is-invalid");
                }
            });

            if (!valid) {
                e.preventDefault();
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Por favor, complete todos los campos obligatorios.",
                });
            }
        }
    });
});

    </script>
@stop
