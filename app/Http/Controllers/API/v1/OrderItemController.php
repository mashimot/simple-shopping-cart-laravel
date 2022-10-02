<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Order;
use Auth;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orderItems = OrderItem::from('order_items as oi')   
            ->join('orders as o', 'o.id', 'oi.order_id')
            ->join('products as p', 'p.id', 'oi.product_id')
            ->join('users as u', 'u.id', 'o.user_id')
            ->join('user_addresses as ua', 'o.user_address_id', 'ua.id')
            ->where('u.id', Auth::user()->id)
            ->orderByDesc('o.created_at')
            ->get([
                'ua.city',
                'ua.country',
                'ua.state',
                'ua.street_name',
                'ua.street_number',
                'ua.cep',
                'u.name as user_name',
                'o.id as order_id',
                'p.name as product_name', 
                'oi.quantity', 
                'oi.amount',
                'o.amount as total_amount'
            ]);

        if(count($orderItems) > 0){
            return collect($orderItems)
                ->groupBy('order_id')
                ->map(function($orderItem){
                    return [
                        'total_amount' => $orderItem->first()->total_amount,
                        'order_id' => $orderItem->first()->order_id,
                        'address' => [
                            'city' => $orderItem->first()->city,
                            'country' => $orderItem->first()->country,
                            'state' => $orderItem->first()->state,
                            'street_name' => $orderItem->first()->street_name,
                            'street_number' => $orderItem->first()->street_number,
                            'cep' => $orderItem->first()->cep,
                        ],
                        'order_items' => $orderItem->map(function($item){
                            return [
                                'product_name' => $item->product_name,
                                'quantity' => $item->quantity,
                                'amount' => $item->amount
                            ];
                        })
                    ];
                })
                ->values()
                ->all();
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
