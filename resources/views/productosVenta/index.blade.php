@extends('adminlte::page')

@section('title', 'Catálogo de Libros')

@section('content')
<div class="container">
    <h1 class="text-center" style="color: var(--color-primary); font-weight: bold;">
        📚 Catálogo de Libros
    </h1>

    <!-- 🔍 Buscador y Filtros -->
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

    <!-- 🔵 Contador del Carrito -->
    <div class="text-end mb-3">
        <span class="badge bg-success p-2">
            🛒 Productos en el carrito: <span id="cantidadTotalCarrito">0</span>
        </span>
    </div>

    @foreach ($productos->groupBy('categoria.nombre') as $categoria => $productosCategoria)
        <div class="mb-4 categoria-container" data-categoria="{{ strtolower($categoria) }}">
            <h2 style="color: var(--color-secondary); font-weight: bold;">{{ $categoria }}</h2>

            <div class="horizontal-scroll">
                @foreach ($productosCategoria as $producto)
                <div class="card producto-card {{ $producto->stock == 0 ? 'stock-agotado' : '' }}"
                    data-nombre="{{ strtolower($producto->producto) }}"
                    data-categoria="{{ strtolower($categoria) }}">
                                        <img src="{{ $producto->foto ? asset('storage/' . $producto->foto) : 'https://via.placeholder.com/150' }}"
                            class="card-img-top"
                            alt="{{ $producto->producto }}">

                        <div class="card-body">
                            <h4 class="card-title nombre-libro">{{ $producto->producto }}</h4>
                            <p class="card-text text-center"><strong>Precio:</strong> <span class="precio-destacado">${{ number_format($producto->precio_venta, 2) }}</span></p>
                            <p class="card-text text-center"><strong>Stock:</strong> {{ $producto->stock }}</p>

                            <p class="card-text text-center categoria-text">
                                <strong>Categoría:</strong> {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                            </p>

                            <!-- ✅ Formulario con AJAX -->
                            <form onsubmit="agregarAlCarrito(event, {{ $producto->id }})">
                                @csrf
                                <div class="form-group">
                                    <input type="number" name="cantidad" value="1" min="1" max="{{ $producto->stock }}" class="form-control cantidad-input">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">🛒 Agregar al Carrito</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection

{{-- prueba de commit-- eliminar mas tarde --}}

@section('js')
<script>
    // Función para filtrar productos
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

            if (matches === 0) {
                categoria.classList.add('hidden');
            } else {
                categoria.classList.remove('hidden');
            }
        });
    }

    // 📌 Función para agregar productos con AJAX
    function agregarAlCarrito(event, productoId) {
        event.preventDefault();

        let form = event.target;
        let cantidad = form.querySelector('.cantidad-input').value;

        fetch(`/carrito/agregar/${productoId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ cantidad: cantidad })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('cantidadTotalCarrito').textContent = data.cantidadTotalCarrito;
                alert('✅ Producto agregado al carrito.');
            } else {
                alert('❌ Error al agregar el producto.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection


@section('css')
<style>
    :root {
        --color-primary: #285C4D; /* Verde oscuro */
        --color-secondary: #B38E5D; /* Marrón elegante */
        --color-white: #ffffff;
    }

    /* 🟢 Personalización del Menú Lateral */
    .main-sidebar {
        background-color: var(--color-primary) !important;
    }

    .nav-sidebar .nav-link {
        color: var(--color-white);
        font-weight: bold;
    }

    .nav-sidebar .nav-icon {
        color: var(--color-white);
    }

    .nav-sidebar .nav-link:hover {
        background-color: var(--color-secondary);
        color: var(--color-white);
    }

    .nav-sidebar .nav-item.menu-open > .nav-link,
    .nav-sidebar .nav-link.active {
        background-color: var(--color-secondary);
        color: var(--color-white);
    }

    .brand-text {
        font-weight: bold;
        font-size: 18px;
    }

    /* 🔵 Estilo de Productos */
    .horizontal-scroll {
        display: flex;
        overflow-x: auto;
        gap: 15px;
        padding-bottom: 10px;
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

    /* ✅ Estilos mejorados */
    .nombre-libro {
        font-size: 1.6rem;
        color: var(--color-primary);
        font-weight: bold;
        text-align: center;
        display: block;
    }

    .categoria-text {
        font-size: 1rem;
        font-weight: bold;
        color: var(--color-secondary);
    }

    .precio-destacado {
        font-size: 20px;
        font-weight: bold;
        color: #28a745;
    }
.producto-card.stock-agotado {
    filter: grayscale(100%);
    opacity: 0.6;
    pointer-events: none;
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

            if (matches === 0) {
                categoria.classList.add('hidden');
            } else {
                categoria.classList.remove('hidden');
            }
        });
    }
</script>
@endsection
