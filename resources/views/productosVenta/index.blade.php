@extends('adminlte::page')

@section('title', 'Productos en Venta')

@section('content')
<div class="container">
    <h1 style="color: var(--color-primary); font-weight: bold;">Catálogo de Libros</h1> 

    <!-- 🔍 Buscador -->
    <div class="mb-4 row">
        <div class="col-md-6">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre..." onkeyup="filterProducts()">
        </div>
        <div class="col-md-6">
            <select id="categoryFilter" class="form-control" onchange="filterProducts()">
                <option value="">Todas las categorías</option>
                @foreach ($productos->groupBy('categoria.nombre') as $categoria => $productosCategoria)
                    <option value="{{ strtolower($categoria) }}">{{ $categoria }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @foreach ($productos->groupBy('categoria.nombre') as $categoria => $productosCategoria)
        <div class="mb-4 categoria-container" data-categoria="{{ strtolower($categoria) }}">
            <!-- Título de la Categoría -->
            <h2 style="color: var(--color-secondary); font-weight: bold;">{{ $categoria }}</h2>

            <!-- Contenedor de Scroll -->
            <div class="horizontal-scroll">
                @foreach ($productosCategoria as $producto)
                    <div class="card producto-card" 
                         data-nombre="{{ strtolower($producto->producto) }}" 
                         data-categoria="{{ strtolower($categoria) }}">
                         
                        <!-- Imagen del producto -->
                        <img src="{{ $producto->foto ? asset('storage/' . $producto->foto) : 'https://via.placeholder.com/150' }}" 
                            class="card-img-top" 
                            alt="{{ $producto->producto }}">

                        <div class="card-body">
                            <h5 class="card-title">{{ $producto->producto }}</h5>
                            <p class="card-text"><strong>Precio:</strong> ${{ number_format($producto->precio_venta, 2) }}</p>
                            <p class="card-text"><strong>Stock:</strong> {{ $producto->stock }}</p>
                            <p class="card-text"><strong>Descripción:</strong> {{ $producto->descripcion ?? 'No disponible' }}</p>
                            
                            <!-- Formulario para agregar al carrito -->
                            <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="number" name="cantidad" value="1" min="1" max="{{ $producto->stock }}" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Agregar al Carrito</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

@endsection

@section('css')
<style>
    :root {
        --color-primary: #285C4D;
        --color-secondary: #B38E5D;
    }

    /* Estilo para el contenedor de scroll */
    .horizontal-scroll {
        display: flex;
        overflow-x: auto;
        gap: 15px;
        padding-bottom: 10px;
        scrollbar-width: thin;
        scrollbar-color: var(--color-primary) transparent;
    }

    .horizontal-scroll::-webkit-scrollbar {
        height: 8px;
    }

    .horizontal-scroll::-webkit-scrollbar-thumb {
        background-color: var(--color-primary);
        border-radius: 10px;
    }

    .producto-card {
        flex: 0 0 250px;
        border: 1px solid var(--color-primary);
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.2s;
    }

    .producto-card:hover {
        transform: scale(1.05);
    }

    .producto-card img {
        height: 180px;
        object-fit: cover;
    }

    .producto-card .card-body {
        text-align: center;
    }

    /* Ocultar categorías sin productos después de la búsqueda */
    .categoria-container.hidden {
        display: none;
    }
</style>
@endsection

@section('js')
<script>
    function filterProducts() {
        let searchInput = document.getElementById('searchInput').value.toLowerCase();
        let selectedCategory = document.getElementById('categoryFilter').value;
        let categorias = document.querySelectorAll('.categoria-container');

        categorias.forEach(categoria => {
            let productos = categoria.querySelectorAll('.producto-card');
            let matches = 0;

            productos.forEach(producto => {
                let nombre = producto.getAttribute('data-nombre');
                let categoriaProducto = producto.getAttribute('data-categoria');

                let matchNombre = nombre.includes(searchInput);
                let matchCategoria = selectedCategory === "" || categoriaProducto === selectedCategory;

                if (matchNombre && matchCategoria) {
                    producto.style.display = "block";
                    matches++;
                } else {
                    producto.style.display = "none";
                }
            });

            // Oculta la categoría si no tiene productos visibles
            if (matches === 0) {
                categoria.classList.add('hidden');
            } else {
                categoria.classList.remove('hidden');
            }
        });
    }
</script>
@endsection
