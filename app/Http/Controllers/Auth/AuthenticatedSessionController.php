<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // return view('auth.login');a
         return view('authentication.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $request->authenticate();

        $request->session()->regenerate();

        // if($request->user()->role == 'admin' || $request->user()->role == 'superadmin' ){
        //     // return redirect()->intended(route('admin#dashboard', absolute: false));
        //     return($request->user());
        // }

          if($request->user()->role == 'admin' || $request->user()->role =='superadmin' ){
            // dd($request->user());
            return to_route('admin#dashboard');
          }else{
            return to_route('customer#home');
          }

        // if($request->user()->role == 'user'){
        //     // return redirect()->intended(route('customer#home', absolute: false));
        //     return to_route('customer#home');
        // }



    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
