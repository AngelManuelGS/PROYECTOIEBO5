@extends('adminlte::page')

@section('title', 'Productos en Venta')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Catálogo de Libros</h1> <!-- Encabezado con espacio ajustado -->

    <div class="row">
        @forelse ($productos as $producto)
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <!-- Imagen del producto -->
                    <img
                        src="{{ $producto->foto ? asset('storage/' . $producto->foto) : 'https://via.placeholder.com/150' }}"
                        class="card-img-top"
                        alt="{{ $producto->producto }}"
                        style="height: 200px; object-fit: cover;"> <!-- Ajusta la altura de la imagen -->

                    <div class="card-body">
                        <!-- Título del producto -->
                        <h5 class="card-title">{{ $producto->producto }}</h5>

                        <!-- Precio del producto -->
                        <p class="card-text">Precio: <strong>${{ number_format($producto->precio_venta, 2) }}</strong></p>

                        <!-- Stock del producto -->
                        <p class="card-text">Stock: {{ $producto->stock }}</p>

                        <!-- Formulario para agregar al carrito -->
                        <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input
                                    type="number"
                                    name="cantidad"
                                    value="1"
                                    min="1"
                                    max="{{ $producto->stock }}"
                                    class="form-control"
                                    placeholder="Cantidad">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2 w-100">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <!-- Mensaje en caso de que no haya productos -->
            <div class="col-12">
                <p class="text-center text-muted">No hay productos disponibles en este momento.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

