<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function store(Request $request){
        //check for missing fields
        if(!$request->orderId||!$request->menuItemId||!$request->quantity){
            return response('One of the mandatory fields is missing' , 400);
        }
        $order = Order::find($request->orderId);
        $menuItem = MenuItem::find($request->menuItemId);
        if(!$order || $order->closedAt || !$menuItem){
            return response('The order item could not be created.' , 400);
        }

        $oi = new OrderItem();
        $oi->orderId = $request->orderId;
        $oi->menuItemId = $request->menuItemId;
        $oi->quantity = $request->quantity;
        $oi->save();

        return response()->json($oi, 201);
    }
}
