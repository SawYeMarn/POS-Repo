<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    //edit profile
    public function edit(){

        return view('customer.profile.edit');
    }

    //update profile
    public function update(Request $request){
        $this->checkValidation($request);
        $data = $this->getData($request);

             if($request->hasFile('image')){
if(Auth::user()->profile != null){
if(file_exists(public_path(). '/profile/'. Auth::user()->profile)){
 unlink(public_path(). '/profile/'. Auth::user()->profile);
}
}$fileName = uniqid()  . $request->file('image')->getClientOriginalName();
    $request->file('image')->move(public_path()."/profile/", $fileName);
    $data['profile'] = $fileName;
}else{
    $data['profile'] = Auth::user()->profile;
}

User::where('id',Auth::user()->id)->update($data);
Alert::success('Success Title','Profile Update Successfully');
return back();

    }

    //check validation profile
    private function checkValidation($request){
        $request->validate([
      'name' => 'required',
      'email' => 'required|unique:users,email,' .Auth::user()->id,
      'phone' =>'required|min:6|max:12',
      'address' =>'max:20'
        ]);
    }
    //get Data
    private function getData($request){
        return[
        'name' => $request->name,
        'email'=>$request->email,
        'phone'=>$request->phone,
        'address'=>$request->address
        ];
    }

      // password change
    public function change(){
        return view('customer.profile.password');
    }
    // password update
    public function passwordupdate(Request $request){

        $customerPassword = Auth::user()->password;
           if(Hash::check($request->oldPassword , $customerPassword)){
            $this->passwordValidation($request);
           User::where('id',Auth::user()->id)->update([
            'password' =>Hash::make($request->newPassword)
            ]);
            Alert::success('Success Title', 'Password Change Successfully');
           return back();

           }else{
           Alert::error('Fail Process', 'Old Password do not match with our record.Please Try Again');
           return back();
           }

    }
    // password validation
    private function passwordValidation($request){
        $request->validate([
         'oldPassword'=>'required',
         'newPassword'=>'required|min:6|max:12',
         'confirmPassword'=>'required|min:6|max:12|same:newPassword'
        ]);
    }

    //contact
    public function contact(){
        return view('customer.contact.report');
    }

    //report
    public function report(Request $request){
        $this->checkreport($request);
        Contact::create([
        'user_id'=>Auth::user()->id,
        'title'=>$request->title,
        'message'=>$request->message
        ]);
         Alert::success('Success Title', 'Message Send Successfully');
        return back();
    }

    //check validation
    private function checkreport($request){
        $request->validate([
            'title'=>'required',
            'message'=>'required|min:6|max:500'
        ]);
    }
}
