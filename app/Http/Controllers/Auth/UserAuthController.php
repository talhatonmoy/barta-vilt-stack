<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserLoginRequest;

class UserAuthController extends Controller
{
    // Display login page
    public function login(){
        return Inertia::render('Auth/Login');
    }

    // Handling login request
    public function authenticate(UserLoginRequest $request){
        $credentials = $request->validated();
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('user.timeline');
        }
    }

    //Logout a user
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.login.create');
    }
}
