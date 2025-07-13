<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;

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
        
       

        // Calculate total quantity and total price from cart items
        $totalQuantity = 0;
        $totalPrice = 0;

        foreach ($this->cartItems as $item) {
            $totalQuantity += $item['quantity'];
            $totalPrice += $item['price'] * $item['quantity'];
        }

        $user       = auth()->user();
            if (isset($user) && $user->balance < $totalPrice) {
                $notify[] = ['error', 'Balance is not sufficient'];
                return back()->withNotify($notify);
            }
  $transaction               = new Transaction();
        $transaction->user_id      =  !empty(Auth::user()->id) ? Auth::user()->id : 0;
        $transaction->amount       = $this->total;
        $transaction->post_balance = !empty(Auth::user()->balance) ? Auth::user()->balance : 0;
        $transaction->charge       = 0;
        $transaction->trx_type     = '-';
        $transaction->details      = 'Order Checkout';
        $transaction->trx          = getTrx();
        $transaction->save();

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
            $product = Product::find($item['product_id']);
  
            if ($product) {
                $product->decrement('quantity', $item['quantity']);
            }
        }
         
      
        if(isset($user)){
            
        $refer_user = User::find($user->ref_by);
          if (!empty($refer_user)) {
            // Example values, replace with actual logic as needed
            $auth_user_percent = determineCommissionRate(auth()->user()->bv_points) + userGroupPoints(auth()->user()); // percent
            $refer_user_percent = determineCommissionRate($refer_user->bv_points+ userGroupPoints($refer_user)) ; // percent
            // Calculate the commission amount for the refer user
            $refer_user_commission = (($product->price * $order->quantity) * $refer_user_percent) / 100;
            // Update the refer user's balance
            // $refer_user->balance += $refer_user_commission;
         
            $refer_user->total_ref_com += $refer_user_commission;
            $refer_user->balance += $refer_user_commission ;
            $refer_user->save();
          
                    // $bonusRefCom = $refer_user->total_ref_com;
                    
                    
                $transaction = new Transaction();
                $transaction->amount = $refer_user_commission;
                $transaction->user_id = $refer_user->id;
                $transaction->charge = 0;
                $transaction->trx_type = '+';
                $transaction->details = $refer_user_percent . ' % - Sponsor Bonus';
                $transaction->remark = 'sponsor_bonus_amount';
                $transaction->trx = getTrx();
                $transaction->post_balance = $refer_user->balance;
                $transaction->save();
                    
                    

                    }

                      $user  = User::find(auth()->user()->id);
        $ancestors = $user->ancestors(); // Collection of all ancestors

        $total_percent =0;
        $list_user= [];
        $app_users =[];
      $previousUser = null; // Initialize previous user tracker

            foreach ($ancestors as $currentUser) {
                // Skip if current user is the referrer
                if ($refer_user->id == $currentUser->id) {
                      $previousUser = $currentUser;
                    continue;
                }
                // Only calculate if $previousUser exists (not first iteration)
                if ($previousUser !== null) {
                    // Calculate commission rates based on PREVIOUS user
                    $last_user_percent = determineCommissionRate($previousUser->bv_points + userGroupPoints($previousUser));
                    $parent_user_percent = determineCommissionRate($currentUser->bv_points + userGroupPoints($currentUser));
                    
                   
                    $diff_value = $parent_user_percent - $last_user_percent;
                     $list_user [] = ['diff_value'=>$diff_value,'parent_user_percent'=>$parent_user_percent
                        ,'last_user_percent'=>$last_user_percent,
                        'user_name'=>$currentUser->username
                     ];
                      $total_percent += $diff_value;
                    
                    if ($total_percent > 0 && $total_percent <= 24 ) {
                        $refer_parent_commission = (($product->price * $order->quantity) * $diff_value) / 100;
                        
                        // Update current user's points
                        if($currentUser->registerion_type == 'affiliate'){
                            $currentUser->bv_points += $refer_parent_commission;
                            $currentUser->gp_points += $refer_parent_commission;
                            $currentUser->balance +=$refer_parent_commission ;
                            $currentUser->save();
                        }else{
                            $currentUser->bv_points += $refer_parent_commission;
                            $currentUser->balance +=$refer_parent_commission ;
                            $currentUser->team_sale_amount += $refer_parent_commission;
                            $currentUser->save();
                        }
                        //Update Transaction Comission
                        // $bonusGP = $currentUser->gp_points;
                            
                            
                        $transaction = new Transaction();
                        $transaction->amount = $refer_parent_commission;
                        $transaction->user_id = $currentUser->id;
                        $transaction->charge = 0;
                        $transaction->trx_type = '+';
                        $transaction->details = $diff_value . ' % - Group Bonus';
                        $transaction->remark = 'group_bonus_amount';
                        $transaction->trx = getTrx();
                        $transaction->post_balance = $currentUser->balance;
                        $transaction->save();
    
                        $app_users [] =$currentUser;
                    }
                }
            
                // Update previous user for next iteration
                $previousUser = $currentUser;
            }

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
