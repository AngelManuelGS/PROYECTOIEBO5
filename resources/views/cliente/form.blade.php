<div class="box box-info padding-1">
    <div class="box-body row">
        <div class="form-group col-md-4">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $cliente->nombre ?? old('nombre'), ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('email') }}
            {{ Form::email('email', old('email'), ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Correo Electrónico']) }}
            {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('contraseña') }}
            {{ Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => 'Contraseña']) }}
            {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('telefono') }}
            {{ Form::text('telefono', $cliente->telefono ?? old('telefono'), ['class' => 'form-control' . ($errors->has('telefono') ? ' is-invalid' : ''), 'placeholder' => 'Teléfono']) }}
            {!! $errors->first('telefono', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-8">
            {{ Form::label('direccion') }}
            {{ Form::text('direccion', $cliente->direccion ?? old('direccion'), ['class' => 'form-control' . ($errors->has('direccion') ? ' is-invalid' : ''), 'placeholder' => 'Dirección']) }}
            {!! $errors->first('direccion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('plante_educativo', 'Plantel Educativo') }}
            {{ Form::text('plante_educativo', $cliente->plante_educativo ?? old('plante_educativo'), ['class' => 'form-control' . ($errors->has('plante_educativo') ? ' is-invalid' : ''), 'placeholder' => 'Plantel Educativo']) }}
            {!! $errors->first('plante_educativo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('region', 'Región') }}
            {{ Form::text('region', $cliente->region ?? old('region'), ['class' => 'form-control' . ($errors->has('region') ? ' is-invalid' : ''), 'placeholder' => 'Región']) }}
            {!! $errors->first('region', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="box-footer mt20 text-right">
        <a href="/clientes" class="btn btn-danger">{{ __('Cancel') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>

</div>
