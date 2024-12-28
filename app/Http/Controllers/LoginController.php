<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
   public function login(){
    return view('admin.login');
   }
   public function loginPost(Request $request){
    // dd($request->all());
    $request->validate([
        'email' => 'required',
        'password' => 'required',  
    ],  
        [
            'email.required' => 'Enter your username',
            'password.required' => 'Enter your password',
        ]);
    $userdata = $request->only('email','password');
    // dd($userdata);
    if(Auth::attempt($userdata)){

        // dd('login successfully');
        return redirect()->route('dashboard');
    }else{


        return redirect()->route('login');
    }
}

public function logout(){

    Auth::logout();
    return redirect()->route('login');
}



}
