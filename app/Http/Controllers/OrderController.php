<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;

class OrderController extends Controller
{
    //direct to order List
    public function list(){

    $orderList = Order::select('products.stock','orders.product_id','orders.count','orders.id','orders.order_code','orders.created_at','orders.status','users.name')
        ->leftJoin('users','orders.user_id','users.id')
        ->leftJoin('products','orders.product_id','products.id')
        ->groupBy('order_code')
        ->orderBy('orders.created_at','desc')
        ->when(request('searchKey'),function($query){
            $query->whereAny(['orders.order_code'], 'like', '%'.request('searchKey').'%');
        })
        ->get();



         return view('admin.order.list',compact('orderList'));
    }

    //order product
    public function product($orderCode){
        $order = Order::select(
        'users.name as userName','users.phone','users.address','orders.id as order_id',
        'orders.order_code','orders.created_at','products.id as product_id','orders.user_id as userId',
        'products.image','products.name','orders.count as order_count','products.stock','products.price')
        ->leftJoin('products','orders.product_id','products.id')
        ->leftJoin('users','orders.user_id','users.id')
        ->where('orders.order_code',$orderCode)
        ->get();

        $paymentHistory = PaymentHistory::select('payment_histories.*','payments.type')
        ->leftJoin('payments','payments.id','payment_histories.payment_method')
         -> where('order_code',$orderCode)->first();

         $status = true ;
         foreach ($order as $item){
        // array_push($orderStatus,$item->order_count > $item->stock ? false : true);
if($item->order_count <= $item->stock){
    $status = true;
}else{
    $status = false;
    break;
}

        }

       // dd($order->toArray());

   return view('admin.order.orderdetail',compact('order','paymentHistory','status'));
    }


    //order reject
    public function orderCode(Request $request){

        Order::where('order_code',$request->orderCode)->update([
            'status' => 2
        ]

        );
         return response()->json([
          'status' => 'success',
          'message' => 'Order reject Successfully'
        ],200);


    }
    //order status change
     public function orderStatusChange(Request $request){


        Order::where('order_code',$request->order_code)->update([
            'status' => $request->status
        ]

        );
         return response()->json([
          'status' => 'success',
          'message' => 'Order reject Successfully'
        ],200);


    }

    public function orderConfirm(Request $request){
       Order::where('order_code',$request[0]['orderCode'])->update([
            'status' => 1
        ]

        );
        foreach($request->all() as $item){
            Product::where('id',$item['productId'])->decrement('stock',$item['count']);
        }
           return response()->json([
          'status' => 'success',
          'message' => 'Order Changed Successfully'
        ],200);
    }
}
