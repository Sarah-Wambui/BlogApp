<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'=>['required', 'email'],
            'password'=>['required']
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            if(auth()->user()->role_id == 1){
                return response()->json(['message'=> 'I am an admin']);
            }else{
                return response()->json(['message'=> 'I am a normal user']);
            }
        }else{
            return response()->json(['message'=>'The credentials you have provided do not match any of our records']);
        }
    }
}
