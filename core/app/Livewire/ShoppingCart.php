<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;

class ShoppingCart extends Component
{
    public $cartItems = [];
    public $total = 0;
    public function render()
    {
         $cartService = new CartService();
        $this->cartItems = $cartService->getCartItems();
        $this->total = $cartService->getCartTotal();
        return view('livewire.shopping-cart', [
            'cartItems' => $this->cartItems,
            'total' => $this->total,
        ]);
    }

    public function removeFromCart($itemId)
    {
        $cartService = new CartService();
        $cartService->removeItem($itemId);
         $this->dispatch('cartUpdated',['name' => '','message' => 'Item removed from cart']);
       
    }
    public function increaseQty($itemId)
    {
        $cartService = new CartService();
        $cartService->increaseItemQuantity($itemId);
        $this->dispatch('cartUpdated',['name' => '','message' => 'Item quantity increased']);
      
        
    }
    public function decreaseQty($itemId)
    {
        $cartService = new CartService();
        $cartService->decreaseItemQuantity($itemId);
        $this->dispatch('cartUpdated',['name' => '','message' => 'Item quantity decreased']);
       
    }
}
