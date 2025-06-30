<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;


class AddToCart extends Component
{
    public $product;
    public $quantity = 1;
    public $message;
    public $cartCount = 0;
    
    protected $listeners = ['cartUpdated' => 'updateCartCount'];
  
 
    public function mount($product)
    {
        $this->product = $product;
        $this->updateCartCount();
    }
    
    public function addToCart()
    {
   
        // $this->valid1ate([
        //     'quantity' => 'required|numeric|min:1|max:100'
        // ]);
         
        $cart = $this->getOrCreateCart();
        
        // Check if product already exists in cart
        $existingItem = $cart->items()->where('product_id', $this->product->id)->first();
        
        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $this->quantity
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $this->product->id,
                'quantity' => $this->quantity,
                'price' => $this->product->price,
            ]);
        }
        
        $this->message = 'Product added to cart!';
       
        $this->dispatch('cartUpdated',['name' => $this->product->name]);
            
            // Replace dispatchBrowserEvent() with dispatch() for browser events
            $this->dispatch('notify', 
                message: $this->message,
                type: 'success'
            );
    }
    
    protected function getOrCreateCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate([
                'user_id' => Auth::id()
            ]);
        }
        
        // For guests, use session ID
        $sessionId = session()->getId();
        return Cart::firstOrCreate([
            'session_id' => $sessionId
        ]);
    }
    
    public function updateCartCount()
    {
        if (Auth::check()) {
            $this->cartCount = Cart::where('user_id', Auth::id())
                ->withCount('items')
                ->first()
                ->items_count ?? 0;
        } else {
            $sessionId = session()->getId();
            $this->cartCount = Cart::where('session_id', $sessionId)
                ->withCount('items')
                ->first()
                ->items_count ?? 0;
        }
    }
    
    public function render()
    {
        return view('livewire.add-to-cart');
    }
}
