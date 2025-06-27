<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    public function payment(){
        $payments = Payment::orderBy('created_at', 'desc')
        ->when(request('searchKey'),function($query){
            $query->whereAny(['payments.account_number','payments.account_name','payments.type'], 'like', '%'.request('searchKey').'%');
        })
        ->paginate(3);
         return view('admin.payment.adminpaymentlist',compact('payments'));
}

// payment Create
public function paymentCreate(Request $request){
    $this->checkValidate($request);
    $data = $this->getData($request);

    Payment::create($data);
    Alert::success('Process Success','Payment Method create Successfully');
    return back();



}

//getData
private function getData($request){
    return  [
        'account_number' => $request->accountNumber,
        'account_name' => $request->accountName,
        'type' => $request->type

    ];

}

// validate Account
private function checkValidate(Request $request){
$rules = [
'accountNumber' => 'required|unique:payments,account_number,' . $request->id,
'accountName' => 'required',
'type' =>'required'
];

$message = [];

$request->validate($rules,$message);

}

// payment delete
public function paymentDelete($id){
    Payment::where('id',$id)->delete();
    Alert::success('Success Title', 'Payment deleted successfully');
        return back();
}


//edit
public function paymentedit($id){
    $payments = Payment::where('id',$id)->first();
    return view('admin.payment.edit',compact('payments'));
}

//update
public function paymentUpdate(Request $request, $id){
 $this->checkValidate($request);
 $data = $this->getData($request);

Payment::where('id', $id)->update($data);
Alert::success('Process Success','Payment Method create Successfully');
    return to_route('payment#admin');

}



}
