<div class="box box-info padding-1">
    <div class="box-body row">
        <!-- Contenedor principal del formulario, con clases de Bootstrap para diseño en columnas -->

        <div class="form-group col-md-4">
            {{ Form::label('name') }}
            <!-- Etiqueta para el campo "name" -->

            {{ Form::text('name', $usuario->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            <!-- Campo de texto para el nombre del usuario. Aplica la clase 'is-invalid' si hay un error de validación -->

            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
            <!-- Muestra un mensaje de error si la validación falla para el campo "name" -->
        </div>

        <div class="form-group col-md-3">
            {{ Form::label('email') }}
            <!-- Etiqueta para el campo "email" -->

            {{ Form::text('email', $usuario->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Correo']) }}
            <!-- Campo de texto para el correo electrónico del usuario. Agrega la clase 'is-invalid' en caso de error de validación -->

            {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
            <!-- Muestra un mensaje de error si hay problemas de validación en el campo "email" -->
        </div>

        <div class="form-group col-md-5">
            {{ Form::label('password') }}
            <!-- Etiqueta para el campo "password" -->

            {{ Form::text('password', null, ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => 'Contraseña']) }}
            <!-- Campo de texto para la contraseña del usuario. No muestra el valor actual por seguridad. Aplica 'is-invalid' si hay errores de validación -->

            {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
            <!-- Muestra un mensaje de error si la validación falla para el campo "password" -->
        </div>
    </div>

    <div class="box-footer mt20 text-right">
        <a href="/usuarios" class="btn btn-danger">{{ __('Cancel') }}</a>
        <!-- Botón para cancelar y regresar a la lista de usuarios -->

        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
        <!-- Botón para enviar el formulario -->
    </div>
</div>
