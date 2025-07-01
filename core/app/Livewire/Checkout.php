<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class Checkout extends Component
{ 
    public $cartItems = [];
    public $total = 0;
    public $first_name='';
    public $last_name='';
    public $email='';
    public $phone='';
    public $country='';
    public $city='';
    public $state='';
    public $order_notes='';
    public $company='';
    public $address='';
    public $zip='';

    public function render()
    {
         $cartService = new CartService();
        $this->cartItems = $cartService->getCartItems();
        $this->total = $cartService->getCartTotal();
        
        return view('livewire.checkout', [
            'cartItems' => $this->cartItems,
            'total' => $this->total,
        ]);
    }

    public function submitOrder()
    {
        
        
        $transaction               = new Transaction();
        $transaction->user_id      =  !empty(Auth::user()->id) ? Auth::user()->id : 0;
        $transaction->amount       = $this->total;
        $transaction->post_balance = !empty(Auth::user()->balance) ? Auth::user()->balance : 0;
        $transaction->charge       = 0;
        $transaction->trx_type     = '-';
        $transaction->details      = 'Order Checkout';
        $transaction->trx          = getTrx();
        $transaction->save();

        // Calculate total quantity and total price from cart items
        $totalQuantity = 0;
        $totalPrice = 0;

        foreach ($this->cartItems as $item) {
            $totalQuantity += $item['quantity'];
            $totalPrice += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'user_id'     => !empty(Auth::user()->id) ? Auth::user()->id : 0,
            'product_id'  => 0,
            'quantity'    => $totalQuantity,
            'price'       => $totalPrice,
            'total_price' => $this->total,
            'trx'         => $transaction->trx,
            'order_notes' => $this->order_notes,
            'order_type'  => !empty(auth()->user()->id) ? 'registered' : 'guest', // Assuming order type is checkout
            'shipping_details' => json_encode([
                'first_name' => $this->first_name,
                'last_name'  => $this->last_name,
                'email'      => $this->email,
                'phone'      => $this->phone,
                'country'    => $this->country,
                'city'       => $this->city,
                'state'      => $this->state,
                'order_notes'=> $this->order_notes,
                'company'    => $this->company,
            ]) , // Assuming shipping address is not required
            'status'      => 0, // Assuming 0 is for pending status
        ]);

        // Save order items
        foreach ($this->cartItems as $item) {
            $order->orderItems()->create([
                'product_id' => $item['product_id'],
                'order_id'   => $order->id,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);
        }

        $this->resetForm();
        return redirect()->route('thankyou', ['order' => $order->id]);
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);
    }
   public function resetForm(){
       $this->first_name = '';
       $this->last_name = '';
       $this->email = '';
       $this->phone = '';
       $this->country = '';
       $this->city = '';
       $this->state = '';
       $this->zip = '';
       $this->address = '';
       $this->order_notes = '';
       $this->company = '';
       $this->cartItems = [];
       $this->total = 0;
       app(CartService::class)->clearCart(); // Clear cart items after order
         session()->flash('success', 'Order placed successfully!');
   }
}
