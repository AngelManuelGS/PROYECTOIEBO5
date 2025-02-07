<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <input wire:model.live="search" type="text" placeholder="Buscar productos..." class="form-control mb-2">

                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body card-container">
                                    <div class="img-container overflow-hidden">
                                        <img class="img-thumbnail"
                                            src="{{ $product->foto ? 'storage/' . $product->foto : 'img/default.png' }}" alt="">
                                    </div>

                                    <h5 class="card-title">{{ $product->producto }}</h5>
                                    <p class="card-text">${{ $product->precio_venta }}</p>
                                    <p><strong>Stock:</strong> {{ $product->stock }}</p>

                                    @if ($product->stock > 0)
                                        <button class="btn btn-primary btn-sm button"
                                            wire:click="addToCart({{ $product->id }})">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>Agotado</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                @if (session()->has('success_message'))
                    <div class="alert alert-success">{{ session('success_message') }}</div>
                @endif

                @if (session()->has('error_message'))
                    <div class="alert alert-danger">{{ session('error_message') }}</div>
                @endif

                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Stock</th>
                            <th>Precio</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <input type="number" wire:model.defer="quantity.{{ $item->rowId }}"
                                        min="1" max="{{ $item->options->stock }}"
                                        wire:change="updateQuantity('{{ $item->rowId }}')"
                                        class="form-control">
                                </td>
                                <td>{{ $item->options->stock }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>
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
            <div class="card-footer">
                <h3>Total del Carrito: ${{ Cart::subtotal() }}</h3>
            </div>
        </div>
    </div>
</div>
