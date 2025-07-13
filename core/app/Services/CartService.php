<?php

// app/Services/CartService.php
namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getCart()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->first();
        }
        
        $sessionId = session()->getId();
        return Cart::where('session_id', $sessionId)->first();
    }
    
    public function addItem($product, $quantity = 1)
    {
        $cart = $this->getCart();
        
        $existingItem = $cart->items()->where('product_id', $product->id)->first();
        
        if ($existingItem) {
            $existingItem->update(['quantity' => $existingItem->quantity + $quantity]);
            return $existingItem;
        }
        
        return CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $product->price,
        ]);
    }
    
    public function getCartCount()
    {
        $cart = $this->getCart();
        
        return $cart?->items()?->count() ?? 0;
    }
    
    public function getCartItems()
    {
        $cart = $this->getCart();
        if (!$cart) {
            return [];
        }
        return $cart->items()->with('product')->get() ?? [];
    }
    public function getCartTotal()
    {
        $cart = $this->getCart();
        if (!$cart) {
            return 0;
        }
        return $cart->items->sum(function($item) {
            return $item->price * $item->quantity;
        });
    }
    
    public function clearCart()
    {
        $cart = $this->getCart();
        $cart->items()->delete();
        return true;
    }
    public function removeItem($itemId)
    {
        $cart = $this->getCart();
        $item = $cart->items()->find($itemId);
        
        if ($item) {
            $item->delete();
            return true;
        }
        
        return false;
    }
    public function increaseItemQuantity($itemId, $quantity = 1)
    {
        $cart = $this->getCart();
        $item = $cart->items()->find($itemId);
        
        if ($item) {
            $item->update(['quantity' => $item->quantity + $quantity]);
            return true;
        }
        
        return false;
    }

    public function decreaseItemQuantity($itemId, $quantity = 1)
    {
        $cart = $this->getCart();
        $item = $cart->items()->find($itemId);

        if ($item) {
            $item->update(['quantity' => $item->quantity - $quantity]);
            return true;
        }

        return false;
    }
}