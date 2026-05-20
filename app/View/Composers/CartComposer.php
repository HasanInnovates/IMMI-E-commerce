<?php

namespace App\View\Composers;

use App\Services\CartService;
use Illuminate\View\View;

class CartComposer
{
    protected CartService $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function compose(View $view): void
    {
        $view->with('cartCount', $this->cart->count());
    }
}
