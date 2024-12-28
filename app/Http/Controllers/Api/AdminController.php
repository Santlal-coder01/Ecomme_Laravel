<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\api\Admin;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
   public function login(Request $request){
    $input = $request->all();

    $validater = Validator::make($input,[
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if($validater->fails()){
        return response()->json([
            'error' => $validater->error()
        ],422);
    }

    
    if(Auth::attempt(['email' =>$request->email,'password'=>$request->password])){
        return response()->json([
            'status' => true,
            'message' => 'user login successfully',
            'token' => Auth::user()->createToken("api token")->plainTextToken,
            'token_type' => 'bearer'
        ],200);
    }else{
        return response()->json([
            'status' => false,
            'message' => 'email and password does not matches with our records.',
        ],401);

    }

   }


   public function logOut(Request $request){
    $user =  $request->user();
    $user->tokens()->delete();


    return response()->json([
        'status' => true,
        'user' => $user,
        'message' => 'you have successfully logged',
    ],200);
   }
}
