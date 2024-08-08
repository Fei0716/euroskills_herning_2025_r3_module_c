<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::all();
        $orders->map(function ($order){
            return[
                "tableId" => $order->id,
                "id" => $order->id,
                "createdAt" => $order->createdAt,
                "updatedAt" => $order->updatedAt,
                "closedAt" => $order->closedAt,
                "orderItems" => $order->orderItems->map(function($item){
                    return [
                        "orderId" => $item->orderId,
                        "menuItemId" => $item->menuItemId,
                        "quantity" => $item->quantity,
                        "id" => $item->id,
                        "createdAt" => $item->createdAt,
                        "updatedAt" => $item->updatedAt,
                        "menuItem" => $item->menuItem,
                    ];
                }),
            ];
        });
        return response()->json($orders, 200);
    }
    public function store(Request $request){
        //check for missing fields
        if(!$request->tableId){
            return response('One of the mandatory fields is missing' , 400);
        }
        //check for open order
        $openOrder = Order::where('tableId' , $request->tableId)->whereNull('closedAt')->first();
        if($openOrder){
            return response('Table already has an open order' , 400);
        }
        $table = Table::find($request->tableId);
        if(!$table){
            return response('Table not found' ,404);
        }

        $order = new Order();
        $order->tableId = $request->tableId;
        $order->save();

        return response()->json($order , 201);
    }
    public function getLastOpenOrderByTable($id, Request $request){
        $order = Order::where('tableId', $id)->whereNull('closedAt')->first();

        if(!$order){
            return response('Order not found' ,404);
        }
        $response = [
            "tableId" => $order->id,
            "id" => $order->id,
            "createdAt" => $order->createdAt,
            "updatedAt" => $order->updatedAt,
            "closedAt" => $order->closedAt,
            "orderItems" => $order->orderItems->map(function($item){
                return [
                    "orderId" => $item->orderId,
                    "menuItemId" => $item->menuItemId,
                    "quantity" => $item->quantity,
                    "id" => $item->id,
                    "createdAt" => $item->createdAt,
                    "updatedAt" => $item->updatedAt,
                    "menuItem" => $item->menuItem,
                ];
            })
        ];
        return response()->json($response, 200);
    }

//    close order
    public function closeOrder($id){
        $order = Order::where('tableId', $id)->whereNull('closedAt')->first();

        if(!$order){
            return response('Order not found' ,404);
        }
        $order->closedAt = now();
        $order->save();

        return response('Order closed successfully.' , 200);
    }
    public function generateStats(){
//        $orders= Order::all();
        $totalRevenue= Order::join('orderItem', 'order.id', 'orderItem.orderId')
        ->join('menuItem' , 'menuItem.id' , 'orderItem.menuItemId')
        ->select(DB::raw('SUM(orderItem.quantity * menuItem.price) as "Total Revenue"' ))
        ->pluck("Total Revenue")
        ->first();
/*        $totalRevenue = $orders->sum(function($order){
            return $order->orderItems->sum(function ($item){
                return $item->menuItem->price * $item->quantity;
            });
        });*/

        $response = [
            "totalRevenue" => $totalRevenue,
            "countOfOrderItem" => MenuItem::all()->map(function($i){
                return[
                    "menuItemId" => $i->id,
                    "menuItemName" => $i->name,
                    "count" => $i->orderItems->count(),
                ];
            }),
        ];

        return response()->json($response, 200);
    }
}
