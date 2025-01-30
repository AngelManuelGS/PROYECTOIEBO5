@extends('adminlte::page')

@section('title', 'Perfil de Usuario')

@section('content_header')
    <h1 class="text-center font-weight-bold" style="color: var(--color-primary);">Perfil de Usuario</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Tarjeta para actualizar información del perfil -->
            <div class="card shadow-sm border-2 mb-4" style="border-color: var(--color-primary); border-radius: 8px;">
                <div class="card-header bg-primary text-white text-center" style="border-radius: 8px 8px 0 0;">
                    <h5 class="mb-0">Actualizar Información de Perfil</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form', ['user' => $user])
                </div>
            </div>

            <!-- Tarjeta para actualizar la contraseña -->
            <div class="card shadow-sm border-2 mb-4" style="border-color: var(--color-primary); border-radius: 8px;">
                <div class="card-header bg-warning text-white text-center" style="border-radius: 8px 8px 0 0;">
                    <h5 class="mb-0">Actualizar Contraseña</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form', ['user' => $user])
                </div>
            </div>

            <!-- Tarjeta para eliminar cuenta -->
            <div class="card shadow-sm border-2" style="border-color: var(--color-danger); border-radius: 8px;">
                <div class="card-header bg-danger text-white text-center" style="border-radius: 8px 8px 0 0;">
                    <h5 class="mb-0">Eliminar Cuenta</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form', ['user' => $user])
                </div>
            </div>

        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        :root {
            --color-primary: #285C4D;
            --color-secondary: #B38E5D;
            --color-danger: #dc3545;
            --color-white: #ffffff;
        }

        .bg-primary {
            background-color: var(--color-primary) !important;
        }

        .bg-warning {
            background-color: var(--color-secondary) !important;
        }

        .bg-danger {
            background-color: var(--color-danger) !important;
        }

        .btn-success {
            background-color: var(--color-secondary);
            color: var(--color-white);
            border: none;
        }

        .btn-danger {
            background-color: var(--color-danger);
            color: var(--color-white);
            border: none;
        }

        .btn-success:hover,
        .btn-danger:hover {
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
    <script>
        console.log('Página de perfil de usuario cargada.');

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    let inputs = this.querySelectorAll('input[required]');
                    for (let input of inputs) {
                        if (input.value.trim() === '') {
                            e.preventDefault();
                            alert('Por favor, complete todos los campos obligatorios.');
                            return;
                        }
                    }
                });
            });
        });
    </script>
@stop
