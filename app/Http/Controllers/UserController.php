<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Retrieve all the users but ensure that only the admin can retrieve them
    public function index(){
        $users = User::all();
        return response()->json(['users'=>$users]);
          
    }

   //Delete a user
   public function destroy($id){
     $user = User::find($id);
     if(!$user){
        return response()->json(['message'=>'User not found'], 404);
     }else{
        $user->delete();
        return response()->json(['message'=>'User deleted successfully']);
     }
   }   
}
