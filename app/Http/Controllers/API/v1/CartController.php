<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Models\UserAddress;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request)
    {
        DB::beginTransaction();
        $user = Auth::user();
        try {
            $totalAmount = collect($request->cart)
                ->sum(function($c) {
                    return $c['price'] * $c['quantity'];
                }, 0);

            $order = new Order();
            $order->user_id = $user->id;
            $order->user_address_id = $request->user_address_id;
            $order->amount = $totalAmount;
            $order->save();

            $response = collect([
                'orders' => collect()
            ]);

            foreach ($request->cart as $cartItem) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cartItem['product_id'];
                $orderItem->quantity = $cartItem['quantity'];
                $orderItem->amount = $cartItem['price'];
                $orderItem->save();

                $response->get('orders')->push([
                    'amount' => $orderItem->amount,
                    'quantity' => $orderItem->quantity
                ]);
            }

            $response->put('order_id', $order->id);
            $response->put('order_description', "Your Order #{$order->id}");
            $response->put('total', $totalAmount);
            
            DB::commit();

            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
