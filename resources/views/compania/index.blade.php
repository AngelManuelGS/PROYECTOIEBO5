@extends('adminlte::page')  <!-- Extiende la plantilla de AdminLTE para estructura y estilo de la página -->

@section('title', 'Dashboard')  <!-- Define el título de la página como "Dashboard" -->

@section('content_header')
    <h1 style="color: var(--color-primary); font-weight: bold;" >Plantel</h1>  <!-- Encabezado principal de la sección de "Compania" -->
@stop

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <!-- Título de la tarjeta -->
                        <span id="card_title">
                            {{ __('Plantel') }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Mensaje de éxito después de realizar una acción como la actualización de la compañía -->
                    @if ($message = Session::get('success'))
                        <div class="alert fade_success .fade">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <!-- Formulario para actualizar los datos de la compañía -->
                    <form method="POST" action="{{ route('compania.update', $compania->id ?? '') }}" role="form">
                        {{ method_field('PUT') }}  <!-- Método PUT para actualizar datos existentes -->
                        @csrf  <!-- Token CSRF para proteger el formulario contra ataques de falsificación de solicitudes -->

                        <div class="box box-info padding-1">
                            <div class="box-body row">
                                <!-- Campo para el nombre de la compañía -->
                                <div class="form-group col-md-4">
                                    {{ Form::label('nombre') }}
                                    {{ Form::text('nombre', $compania->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
                                    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <!-- Campo para el teléfono de la compañía -->
                                <div class="form-group col-md-4">
                                    {{ Form::label('telefono') }}
                                    {{ Form::text('telefono', $compania->telefono, ['class' => 'form-control' . ($errors->has('telefono') ? ' is-invalid' : ''), 'placeholder' => 'Teléfono']) }}
                                    {!! $errors->first('telefono', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <!-- Campo para el correo electrónico de la compañía -->
                                <div class="form-group col-md-4">
                                    {{ Form::label('correo') }}
                                    {{ Form::text('correo', $compania->correo, ['class' => 'form-control' . ($errors->has('correo') ? ' is-invalid' : ''), 'placeholder' => 'Correo']) }}
                                    {!! $errors->first('correo', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <!-- Campo para la dirección de la compañía -->
                                <div class="form-group col-md-5">
                                    {{ Form::label('direccion') }}
                                    {{ Form::text('direccion', $compania->direccion, ['class' => 'form-control' . ($errors->has('direccion') ? ' is-invalid' : ''), 'placeholder' => 'Dirección']) }}
                                    {!! $errors->first('direccion', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <!-- Botón de envío del formulario -->
                            <div class="box-footer mt20 text-right">
                                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <!-- Enlace a un archivo CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection
