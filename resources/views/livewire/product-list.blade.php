<div class="row">
    <!-- Sección principal con dos columnas -->
    <div class="col-md-7">
        <!-- Columna izquierda: lista de productos -->
        <div class="card">
            <div class="card-body">
                <!-- Campo de búsqueda -->
                <input wire:model.live="search" type="text" placeholder="Buscar productos..."
                    class="form-control mb-2">
                <!-- Búsqueda en vivo utilizando Livewire, sincronizando con el modelo "search" -->

                <div class="row">
                    @foreach ($products as $product)
                        <!-- Itera sobre cada producto en la lista -->
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body card-container">
                                    <!-- Contenedor de la imagen del producto -->
                                    <div class="img-container overflow-hidden">
                                        <img class="img-thumbnail"
                                            src="{{ $product->foto ? 'storage/' . $product->foto : 'img/default.png' }}"
                                            alt="">
                                        <!-- Imagen del producto; si no hay una, muestra una imagen por defecto -->
                                    </div>
                                    <!-- Botón para agregar al carrito -->
                                    <button class="btn btn-primary btn-sm button" type="button" wire:click="addToCart({{ $product->id }})">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                    <!-- Nombre y precio del producto -->
                                    <h5 class="card-title">{{ $product->producto }}</h5>
                                    <p class="card-text">${{ $product->precio_venta }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Paginación para la lista de productos -->
            <div class="card-footer">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <!-- Columna derecha: carrito de compras -->
        <div class="card">
            <div class="card-body">
                @if ($message = Session::get('success_message'))
                    <!-- Muestra un mensaje de éxito si está disponible en la sesión -->
                    <div class="alert fade_success .fade">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <!-- Tabla para los artículos del carrito -->
                <table class="table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th></th>
                            <!-- Encabezados de la tabla del carrito -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <!-- Itera sobre cada artículo en el carrito -->
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <!-- Campo de cantidad que actualiza en tiempo real con Livewire -->
                                    <input type="number" wire:model.defer="quantity.{{ $item->rowId }}"
                                        wire:change="updateQuantity('{{ $item->rowId }}')" class="form-control">
                                </td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>
                                    <!-- Botón para eliminar el artículo del carrito -->
                                    <button wire:click="removeFromCart('{{ $item->rowId }}')"
                                            class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pie de página con el total del carrito -->
            <div class="card-footer">
                <h3>Total del Carrito: ${{ Cart::subtotal() }}</h3>
                <!-- Muestra el subtotal del carrito usando el helper `Cart::subtotal()` -->
            </div>
        </div>
    </div>
</div>
