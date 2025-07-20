<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Constants\Status;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index($userId = null)
    {
        $pageTitle = 'Orders';
        $orders    = Order::searchable(['trx', 'user:username', 'product:name']);
        if ($userId) {
            $orders = $orders->where('user_id', $userId);
        }
        $orders = $orders->with('product', 'user','orderItems')->orderBy('id', 'desc')->paginate(getPaginate());

        $emptyMessage = 'Order not found';
        return view('admin.orders', compact('pageTitle', 'orders', 'emptyMessage'));
    }

    public function status(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,2'
        ]);

        $order   = Order::where('status', Status::ORDER_PENDING)->with('orderItems')->findOrFail($id);
        // $product = $order->product;
        $user    = $order->user;
        if(!$user) {
           $order->status = Status::ORDER_SHIPPED;
            $order->save();
              $notify[] = ['success', 'Order status updated successfully'];
        return back()->withNotify($notify);
        }
        if ($request->status == Status::ORDER_SHIPPED) {
            $order->status = Status::ORDER_SHIPPED;
            $details       =  ' product purchase';
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                  awardBusinessVolume($user->id, $product->bv*$item->quantity, $details);
            }
   
            $template = 'ORDER_SHIPPED';
        } else {
            
            $order->status  = Status::ORDER_CANCELED;
            $user->balance += $order->total_price;
            $user->save();

            $transaction               = new Transaction();
            $transaction->user_id      = $order->user_id;
            $transaction->amount       = $order->total_price;
            $transaction->post_balance = $user->balance;
            $transaction->charge       = 0;
            $transaction->trx_type     = '+';
            $transaction->details      = $product->name . ' Order cancel';
            $transaction->trx          = $order->trx;
            $transaction->save();

            $product->quantity += $order->quantity;
            $product->save();

            $template = 'ORDER_CANCELED';
        }

        $order->save();

        notify($user, $template, [
            'product_name' => $product->name ?? 'N/A',
            'quantity'     => $request->quantity ?? 0,
            'price'        => showAmount($product->price ?? 0,  false),
            'total_price'  => showAmount($order->total_price ?? 0,  false),
            'trx'          => $order->trx,
        ]);

        $notify[] = ['success', 'Product status updated successfully'];
        return back()->withNotify($notify);
    }
}
