<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Register a user
    public function store(Request $request)
    {
        $user =User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password'))
        ]);

        return response()->json(['user'=>$user]);
    }

    // Authenticate a user
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

    // Logout a user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message'=>'Logout successful']);
        // return redirect('/')
    }
}
