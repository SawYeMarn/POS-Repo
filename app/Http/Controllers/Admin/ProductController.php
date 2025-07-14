<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function createPage(){
        $categories = Category::get();
        return view('admin.product.createPage',compact('categories'));
    }


   public function create(Request $request){
  $this->validateProductData($request,'create');
  $data = $this->getProductData($request);


  if($request->hasFile('image')){
    $fileName = uniqid()  . $request->file('image')->getClientOriginalName();
    $request->file('image')->move(public_path()."/productImage/", $fileName);
    $data['image'] = $fileName;
  }
    Product::create($data);

    return to_route('product#createPage')->with(['createSuccess' => 'Product created successfully!']);
    }

// get Product data

private function getProductData(Request $request)
    {
        return [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->categoryId,
            'stock' => $request->stock,


        ];
    }
// Check Validation for Product data
    private function validateProductData($request,$action)
    {
       $rules = [
            'name' => 'required|max:50'  ,
            'price' => 'required|numeric|min:0',
            'description' => 'required|max:2555',
            'categoryId' => 'required',
            'stock'=>'required|numeric|min:1',
        ];
        $rules['image'] = $action == 'create' ?  'required|image|mimes:jpeg,png,jpg,gif,svg':'file|mimes:jpeg,png,jpg,gif,svg';

        $message = [];

        $request->validate($rules, $message);


    }

    //product List
    public function list($action = 'default'){
        $products = Product::select('products.id','products.name','products.price','products.stock','products.image','products.category_id','categories.name as category_name')
        ->LeftJoin('categories','products.category_id','categories.id')
        ->when($action == 'lowAmt',function($query){
            $query->where('products.stock','<=',3);
        })
        ->when($action == 'highAmt',function($query){
            $query->where('products.stock','>',3);
        })
        ->when(request('searchKey'),function($query){
            $query->whereAny(['products.name','products.price','categories.name'], 'like', '%'.request('searchKey').'%');
        })
        ->orderBy('products.created_at','desc')
        ->get();
        return view('admin.product.list',compact('products'));
    }

    //Product delete
 public function delete($id){
 $oldImage = Product::where('id',$id)->value('image');
    // dd($oldImage);
    if(file_exists(\public_path('productImage/'.$oldImage))){ //delete if old image exist
        unlink(public_path('productImage/'.$oldImage));}
    Product::where('id',$id)->delete();
    return back()->with(['deleteSuccess' => 'Product deleted successfully!']);
 }

 //product edit page
 public function edit($id){
    $categories = Category::get();
    $product = Product::where('id',$id)->first();
    return view('admin.product.edit',compact('product','categories'));
 }


public function update(Request $request){

//  $request['id'] = $id; // Add the ID to the request data
$this->validateProductData($request,'update');
$data = $this->getProductData($request);
// dd($data);

 if($request->hasfile('image')){
         $oldImage= $request->productImage; //old image name
           if(file_exists(\public_path('productImage/'.$oldImage))){ //delete if old image exist
            unlink(public_path('productImage/'.$oldImage));

                 $fileName=uniqid() . $request->file('image')->getClientOriginalName();
    $request->file('image')->move(public_path().'/productImage/', $fileName);
    $data['image']  = $fileName;
    }else{
        $data['image']=$request->productImage;
    }

}

Product::where('id',$request->productId)->update($data);

// Product:: find($id)->update($data);
return to_route('product#list')->with(['updateSuccess' => 'Product updated successfully!']);

// Product::where('id',$id)->update($data);
//     return to_route('product#list')->with(['updateSuccess' => 'Product updated successfully!']);




}

//product detail
public function detail($id){
    $categories = Category::get();
    $product = Product::where('id',$id)->first();

    return view('admin.product.detail',compact('product','categories'));
}



}
