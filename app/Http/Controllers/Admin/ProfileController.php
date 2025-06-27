<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    //change oassword page
    public function changePasswordPage(){
        return view('admin.profile.changePassword');
        //old password = password
        // min 6 :max 12
        // new pw == comfirm pw
    }
    public function changePassword(Request $request){

        $userRegisterPassword = Auth::user()->password;
        if(Hash::check($request->oldPassword,$userRegisterPassword)){
          $this->checkPasswordValidation($request);
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

    // password validation check
    private function checkPasswordValidation($request){
        $request->validate([
'oldPassword' =>'required',
'newPassword' =>'required|min:6|max:12|',
'confirmPassword' => 'required|min:6|max:12|same:newPassword'
        ]);
    }

    // profile edit

public function profileEdit(){
    return view('admin.profile.profileEdit');
}

// update profile
public function profileUpdate(Request $request){
   $this->checkValidation($request);
    $data = $this->getProfileData($request);
    // dd('this is yemarn');

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

//get profile data
private function getProfileData($request){
return[
'name' => $request->name,
'email' =>$request->email,
'phone' =>$request->phone,
'address'=> $request->address
];
}

// profile validation
    private function checkValidation($request){
        $request->validate([
'name' =>'required',
'email' =>'required|unique:users,email,' . Auth::user()->id,
'phone' => 'required|min:6|max:12',
'address'=> 'max:200',
'image' => 'file|mimes:jpg,png,jpeg,svg,gif'
        ]);


    }


}
