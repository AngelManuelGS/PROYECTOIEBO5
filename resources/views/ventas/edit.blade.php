@extends('adminlte::page')

@section('title', 'Editar Venta')

@section('content')
<h1>Editar Venta {{ $venta->id }}</h1>

<form action="{{ route('ventas.update', $venta->id) }}" method="POST">
    @csrf
    <div class="card mb-4">
        <div class="card-header">
            <h3>Información General</h3>
        </div>
        <div class="card-body">
            <label for="estado">Estado</label>
            <select name="estado" class="form-control">
                <option value="pendiente" {{ $venta->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="aprobado" {{ $venta->estado === 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                <option value="cancelado" {{ $venta->estado === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Productos</h3>
        </div>
        <div class="card-body">
            @foreach ($venta->detalleventa as $detalle)
                <div class="mb-3">
                    <label>{{ $detalle->producto->producto }}</label>
                    <input type="number" name="productos[{{ $detalle->id }}][cantidad]" value="{{ $detalle->cantidad }}" class="form-control">
                    <input type="number" name="productos[{{ $detalle->id }}][precio]" value="{{ $detalle->precio }}" class="form-control">
                </div>
            @endforeach
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
</form>
@endsection
