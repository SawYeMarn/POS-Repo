<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function home(){
// if(request('sortingType')){
//     $sortingRules = explode(',',request('sortingType'));
//     dd($sortingRules);
// }

        //direct user homepage
        $products = Product::select('products.id','products.name','products.price','products.description','products.category_id','products.image','products.created_at','categories.name as category_name')
        ->leftJoin('categories','products.category_id','categories.id')
        ->when(request('categoryId'),function($query){
            $query->where('products.category_id',request('categoryId'));
        })
        ->when(request('searchKey'),function($query){
            $query->where('products.name','like', '%'.request('searchKey').'%');
        })
        //min == true || max == ture
        ->when(request('minPrice') != null && request('maxPrice') != null,function($query){
            $query->whereBetween('products.price',[request('minPrice'),request('maxPrice')]);
        })

        //min = ture | max=false
         ->when(request('minPrice') != null && request('maxPrice') == null,function($query){
            $query->where('products.price','>=',request('minPrice'));
        })
        //min=false | max=ture
         ->when(request('minPrice') == null && request('maxPrice') != null,function($query){
          $query->where('products.price','<=',request('maxPrice'));
        })
        ->when(request('sortingType'),function($query){
            $sortingRules = explode(',',request('sortingType'));
            $query->orderBy('products.'.$sortingRules[0],$sortingRules[1]);//(fieldNamem asc|desc)
        })
// orderBy Date:

        ->get();


        $categories = Category::select('id','name')->get();




        return view('customer.home.list',compact('products','categories'));
    }

    //direct product detail
    public function productDetails($id){
        $products = Product::select('products.id','products.name','products.price','products.description','products.stock','products.category_id','products.image','products.created_at','categories.name as category_name')
        ->leftJoin('categories','products.category_id','categories.id')
        ->where('products.id',$id)
        ->first();
        $comments = Comment::select('comments.id as comment_id','comments.message','comments.created_at','users.id as user_id','users.name','users.profile')
        ->where('comments.product_id',$id)
        ->leftJoin('users','users.id','comments.user_id')
        ->orderBy('comments.created_at','desc')
        ->get();

         $ratings = number_format(Rating::where('product_id',$id)->avg('count'));

         $userRating=number_format(Rating::where('product_id',$id)->where('user_id',Auth::user()->id)->value('count'));


        return view('customer.layouts.detail',compact('products','comments','ratings','userRating'));
    }

    //comment
    public function comment(Request $request){
Comment::create([
'product_id'=>$request->productId,
'user_id'=>Auth::user()->id,
'message'=>$request->comment,
'created_at'=>Carbon::now()
]);

Alert::success('Success Title','Comment Created Successfully');
return back();
    }

   // delete comment
public function commentDelete($id){
   Comment::where('id',$id)->delete();
//    Alert::success('Success Title','Comment Delete Successfully');
   return back();

}

//rating
public function payrate(Request $request){
//     Rating::create([
// 'product_id'=>$request->productId,
// 'user_id'=>Auth::user()->id,
// 'count'=>$request->productRating,

//     ]);
Rating::updateOrCreate([
    'user_id'=>Auth::user()->id,
    'product_id'=>$request->productId,
],[
    'product_id'=>$request->productId,
'user_id'=>Auth::user()->id,
'count'=>$request->productRating,

]);
    return back();
}

//cart
public function cart(){
    $carts = Cart::select('carts.id as cart_id','carts.qty','products.id as product_id','products.name','products.price','products.image')
    ->leftJoin('products','carts.product_id','products.id')
    ->where('carts.user_id',Auth::user()->id)
    ->get();

    $total = 0;
    foreach($carts as $item){
        $total += $item->price * $item->qty;

    }
    return view('customer.layouts.cart',compact('carts','total'));
}

/// add to cart
public function addtocart(Request $request){
    Cart::create([
 'user_id'=>$request->userId,
 'product_id'=>$request->productId,
 'qty'=>$request->qty
    ]);
    Alert::success('Success Title','Add to Cart Successfully');
    return back();
}

// cart delete
public function cartDelete(Request $request){

    $cardId = $request['cardId'];

    Cart::where('id',$cardId)->delete();

    return response()->json([
        'status' => 'success',
        'message' =>' cart delete success'
    ],200);

}

//direct to payment page
public function paymentPage(){


    $payments = Payment::select('id','account_name','account_number','type')->orderBy('account_name','asc')->get();
    $orderTemp = Session::get('tempCart');

    return view('customer.layouts.payment',compact('payments','orderTemp'));
}


//temp storage
public function tempStorage(Request $request){

    $orderTemp = [];

    foreach($request->all() as $item){

        array_push($orderTemp,[
            'user_id' => $item['user_id'],
             'product_id' => $item['product_id'],
              'count' => $item['count'],
               'status' => $item['status'],
                'order_code' => $item['order_code'],
                'finalAmt' => $item['totalAmt']
        ]);

        Session::put('tempCart', $orderTemp);

         return response()->json([
        'status' => 'success',
        'message' =>' cart delete success'
    ],200);

    }


}

//order product
public function order(Request $request){
    // $request->validate([
    //  'name' => 'required',
    //  'phone' => 'required|numeric',
    //  'address' => 'required|max:200',
    //  'paymentType' => 'required',
    //  'paySlipImage' => 'required|mimes:png,jpg',
    // ]);
   $orderTemp = Session::get('tempCart');

  $paymentHistoryData = [
    'user_name' => $request->name,
    'phone'=>$request->phone,
    'address'=>$request->address,
    'payment_method'=>$request->paymentType,
    'order_code'=>$request->orderCode,
    'total_amt'=>$request->totalAmount

   ];
      if($request->hasFile('payslipImage')){
      $fileName = uniqid()  . $request->file('payslipImage')->getClientOriginalName();
      $request->file('payslipImage')->move(public_path()."/payslipImage/", $fileName);
       $paymentHistoryData['payslip_image'] = $fileName;
  }

 PaymentHistory::create($paymentHistoryData);

foreach($orderTemp as $item){
    Order::create([
        // 'user_id'=>$item['user_id'],
        // 'product_id'=>$item['product_id'],
        // 'count'=>$item['count'],
        // 'status'=>$item['status'],
        // 'order_code'=>$item['order_code'],
          'user_id' => $item['user_id'],
             'product_id' => $item['product_id'],
              'count' => $item['count'],
               'status' => $item['status'],
                'order_code' => $item['order_code']
    ]);
}

 Alert::success('Success Title','Order Created Successfully');
 return to_route('customer#orderList');


}


//order list
public function orderList(){
    $orders = Order::where('user_id',Auth::user()->id)
    ->groupBy('order_code')
    ->orderBy('created_at','desc')
    ->get();
    return view('customer.order.list',compact('orders'));
}

//order detail

}
