<?php

namespace App\View\Components;

use App\Facades\Cart;
use App\Repositories\cart\cartRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartMenu extends Component
{
    public $items;
    public $total;
    /**
     * Create a new component instance.
     */
    public function __construct(cartRepository $cart)
    {
        $this->items=$cart->get();
        $this->total=$cart->total();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-menu');
    }
}
