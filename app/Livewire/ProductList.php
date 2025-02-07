<?php

namespace App\Livewire;

use App\Models\Producto;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 8;
    public $quantity = [];

    public function render()
    {
        $products = Producto::where('producto', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);

        $cartItems = Cart::content();

        foreach ($cartItems as $item) {
            $this->quantity[$item->rowId] = $item->qty;
        }

        return view('livewire.product-list', ['products' => $products, 'cartItems' => $cartItems]);
    }

    public function addToCart($productId)
    {
        $product = Producto::find($productId);

        if (!$product) {
            session()->flash('error_message', 'El producto no existe.');
            return;
        }

        $cartItem = Cart::search(fn($cart) => $cart->id == $productId)->first();
        $currentQty = $cartItem ? $cartItem->qty : 0;

        if ($currentQty + 1 > $product->stock) {
            session()->flash('error_message', 'No puedes agregar más de la cantidad disponible.');
            return;
        }

        Cart::add([
            'id' => $product->id,
            'name' => $product->producto,
            'price' => $product->precio_venta,
            'qty' => 1,
            'options' => ['stock' => $product->stock] // Guardar stock en las opciones del carrito
        ]);

        session()->flash('success_message', 'Producto agregado al carrito.');
    }

    public function updateQuantity($rowId)
    {
        $newQty = $this->quantity[$rowId] ?? 1;
        $cartItem = Cart::get($rowId);

        if (!$cartItem) {
            session()->flash('error_message', 'El producto no está en el carrito.');
            return;
        }

        if ($newQty > $cartItem->options->stock) {
            session()->flash('error_message', 'No puedes seleccionar más de la cantidad en stock.');
            return;
        }

        Cart::update($rowId, ['qty' => $newQty]);
    }

    public function removeFromCart($rowId)
    {
        Cart::remove($rowId);
        session()->flash('success_message', 'Producto eliminado del carrito.');
    }
}
