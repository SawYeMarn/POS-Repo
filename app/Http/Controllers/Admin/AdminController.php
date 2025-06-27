<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    //direct admin dashboard
    public function dashboard(){

$totalSaleAmount = PaymentHistory::sum('total_amt');
$orderrequest = Order::whereIn('status',[0,1])->count('status');
$user = User::where('role','user')->count('id');
$orderPending = Order::whereIn('status',[0])->count('id');


        return view('admin.dashboard.main',compact('totalSaleAmount','orderrequest','user','orderPending'));
    }

    //ceate new Admin Page
    public function createAdminPage(){
return view('admin.account.newadmin');
    }

    //create Admin
    public function createAdmin(Request $request){
     $this->checkAdminValidation($request);
     User::create([
      'name' => $request->name,
      'email'=>$request->email,
      'password'=>Hash::make($request->password),
      'role'=>'admin',
      'cerated_at'=>Carbon::now(),
      'updated_at'=>Carbon::now(),
     ]);
       Alert::success('Success Title', 'New Admin Account created successfully');
        return back();
    }

    //check vamidation
    private function checkAdminValidation(Request $request){
        $request->validate([
          'name'=>'required',
          'email'=>'required|unique:users,email',
          'password'=>'required|min:6|max:12',
          'confirmPassword'=>'required|min:6|max:12|same:password',
        ]);
    }




      public function adminlist(){
$admin = User::select('id','name','email','address','phone','profile','created_at','updated_at','role','provider','nickname')
           ->WhereIn('role',['admin','superadmin'])
           ->when(request('searchKey'),function($query){
            $query->whereAny(['name','email','address','phone','provider','role'], 'like', '%'.request('searchKey').'%');
        })
           ->paginate('3');

return view('admin.account.adminlist',compact('admin'));
    }

    //admin delete
    public function admindelete($id){
 User::where('id',$id)->delete();
 Alert::success('Title Success',"Deleted Successfully");
 return back();
    }

      public function userlist(){
        $users = User::select('id','profile','name','email','address','phone','role','created_at','provider')
        ->where('role','user')
        ->when(request('searchKey'),function($query){
            $query->whereAny(['name','email','address','phone','role'],'like','%'.request('searchKey').'%');
        })
        ->paginate('4');
return view('admin.account.userlist',compact('users'));
    }

    // user delete
    public function userDelete($id){
User::where('id',$id)->delete();
 Alert::success('Title Success',"Deleted Successfully");
 return back();

    }





}
