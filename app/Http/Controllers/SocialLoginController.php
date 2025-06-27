<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SOcialLoginController extends Controller
{
  public function redirect($provider){
  return Socialite::driver($provider)->redirect();

}

public function callback($provider){
      $socialLoginData= Socialite::driver($provider)->user();
    //   dd($socialLoginData);

    $user = User::updateOrCreate([
        'provider_id' => $socialLoginData->id,
    ], [
        'name' => $socialLoginData->name,
        'email' => $socialLoginData->email,
        'nicakname'=>$socialLoginData->nickname,
        'profile'=> $socialLoginData->avatar,
        'provider' =>$provider,
        'provider_id'=>$socialLoginData->id,
        "provider_token"=>$socialLoginData->token,
        'role' => 'user',
    ]);

    Auth::login($user);

    return to_route('customer#home');
}
}
