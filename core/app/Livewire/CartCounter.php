<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;

class CartCounter extends Component
{
    protected $listeners = ['cartUpdated' => 'render'];
    
    public function render()
    {
        $cartService = new CartService();
        $count = $cartService->getCartCount();
        
        return view('livewire.cart-counter', [
            'count' => $count
        ]);
    }
}
