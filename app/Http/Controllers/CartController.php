<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    protected CartService $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function index(): View
    {
        $items = $this->cart->getItems();
        $total = $this->cart->total();

        return view('shop.cart', compact('items', 'total'));
    }

    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->isOutOfStock()) {
            return back()->withErrors(['error' => 'This product is out of stock.']);
        }

        $quantity = min($request->quantity, $product->stock);

        $this->cart->add($product, $quantity);

        return redirect()->route('cart.index')
            ->with('status', "\"{$product->name}\" added to cart.");
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $this->cart->update($request->product_id, $request->quantity);

        return redirect()->route('cart.index')
            ->with('status', 'Cart updated successfully.');
    }

    public function remove(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $this->cart->remove($request->product_id);

        return redirect()->route('cart.index')
            ->with('status', 'Item removed from cart.');
    }

    public function clear(): RedirectResponse
    {
        $this->cart->clear();

        return redirect()->route('cart.index')
            ->with('status', 'Cart cleared.');
    }
}
