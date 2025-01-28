<div class="form-group">
    <!-- Campo para el nombre de la categoría -->
    {{ Form::label('nombre', 'Nombre de la Categoría') }}
    {{ Form::text('nombre', $categoria->nombre ?? '', ['class' => 'form-control', 'placeholder' => 'Nombre de la Categoría']) }}
</div>

<div class="form-group">
    <!-- Campo para el año del ciclo escolar -->
    {{ Form::label('anio', 'Año del Ciclo Escolar') }}
    {{ Form::number('anio', $categoria->anio ?? '', ['class' => 'form-control', 'placeholder' => 'Ejemplo: 2025']) }}
</div>

<div class="form-group">
    <!-- Campo para seleccionar el ciclo escolar (A/B) -->
    {{ Form::label('ciclo', 'Ciclo Escolar') }}
    {{ Form::select('ciclo', ['A' => 'A', 'B' => 'B'], $categoria->ciclo ?? '', ['class' => 'form-control', 'placeholder' => 'Seleccionar Ciclo']) }}
</div>

<div class="form-group">
    <!-- Botón para guardar la categoría -->
    {{ Form::submit('Guardar', ['class' => 'btn btn-primary']) }}
    <!-- Botón para cancelar -->
    <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
</div>
