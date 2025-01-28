<div class="box box-info padding-1">
    <div class="box-body row">
        <!-- Contenedor principal del formulario, utilizando Bootstrap para el diseño en varias columnas -->

        <div class="form-group col-md-4">
            {{ Form::label('codigo') }}
            <!-- Etiqueta para el campo "Código" -->
            {{ Form::text('codigo', $producto->codigo, ['class' => 'form-control' . ($errors->has('codigo') ? ' is-invalid' : ''), 'placeholder' => 'Codigo']) }}
            <!-- Campo de texto para el código del producto. Aplica clase 'is-invalid' si hay un error de validación -->
            {!! $errors->first('codigo', '<div class="invalid-feedback">:message</div>') !!}
            <!-- Mensaje de error en caso de que el campo "codigo" falle la validación -->
        </div>

        <div class="form-group col-md-5">
            {{ Form::label('producto') }}
            {{ Form::text('producto', $producto->producto, ['class' => 'form-control' . ($errors->has('producto') ? ' is-invalid' : ''), 'placeholder' => 'Producto']) }}
            {!! $errors->first('producto', '<div class="invalid-feedback">:message</div>') !!}
            <!-- Campo de texto para el nombre del producto con mensaje de error si falla la validación -->
        </div>

        <div class="form-group col-md-3">
            {{ Form::label('precio_compra') }}
            {{ Form::text('precio_compra', $producto->precio_compra, ['class' => 'form-control' . ($errors->has('precio_compra') ? ' is-invalid' : ''), 'placeholder' => 'Precio Compra']) }}
            {!! $errors->first('precio_compra', '<div class="invalid-feedback">:message</div>') !!}
            <!-- Campo de texto para el precio de compra con validación -->
        </div>

        <div class="form-group col-md-3">
            {{ Form::label('precio_venta') }}
            {{ Form::text('precio_venta', $producto->precio_venta, ['class' => 'form-control' . ($errors->has('precio_venta') ? ' is-invalid' : ''), 'placeholder' => 'Precio Venta']) }}
            {!! $errors->first('precio_venta', '<div class="invalid-feedback">:message</div>') !!}
            <!-- Campo de texto para el precio de venta con validación -->
        </div>

        <div class="form-group">
            {{ Form::label('id_categoria', 'Categoría:') }}
            {!! Form::select('id_categoria', $categorias, $producto->id_categoria, ['class' => 'form-control', 'placeholder' => 'Selecciona una categoría']) !!}
            <!-- Menú desplegable para seleccionar la categoría del producto -->
        </div>

        <div class="form-group col-md-3">
            {{ Form::label('stock', 'Stock') }}
            <!-- Etiqueta para el campo "Stock" -->
            {{ Form::number('stock', $producto->stock, ['class' => 'form-control' . ($errors->has('stock') ? ' is-invalid' : ''), 'placeholder' => 'Stock', 'min' => 0]) }}
            <!-- Campo numérico para el stock del producto. Valor mínimo de 0 -->
            {!! $errors->first('stock', '<div class="invalid-feedback">:message</div>') !!}
            <!-- Muestra un mensaje de error si el campo "stock" no pasa la validación -->
        </div>

        <div class="form-group col-md-4">
            {{ Form::label('foto', 'Foto') }}
            {{ Form::file('foto', ['class' => 'form-control' . ($errors->has('foto') ? ' is-invalid' : ''), 'placeholder' => 'Foto']) }}
            {!! $errors->first('foto', '<div class="invalid-feedback">:message</div>') !!}
            <!-- Campo de archivo para cargar la foto del producto. Muestra un error si no cumple con la validación -->

            @if ($producto->foto)
            <img src="{{ asset('storage/uploads/' . $producto->foto) }}" alt="Imagen del Producto" style="max-width: 100px; max-height: 100px;">
            <!-- Muestra la imagen actual del producto si existe -->
            @else
                <p>Sin imagen</p>
                <!-- Muestra un mensaje si no hay imagen disponible -->
            @endif
        </div>
    </div>

    <div class="box-footer mt20 text-right">
        <a href="/productos" class="btn btn-danger">{{ __('Cancel') }}</a>
        <!-- Botón para cancelar y volver a la lista de productos -->

        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
        <!-- Botón para enviar el formulario -->
    </div>
</div>
