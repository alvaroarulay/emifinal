<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //

    public function show(){
        if(Auth::check()){
            return redirect()->route('home.index');
        }
        return view('auth.register');
    }

    public function register(RegisterRequest $request){
        
        //$user = User::create($request->validated());
        
        $user = new User;
        $user->unidad='OFCEN';
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->codresp = 1;
        $user->codofic = 1;
        $user->idrol=1;
        $user->password = Hash::make($request->password);
        $user->save();
        auth()->login($user);
        return redirect('/home')->with('success', "Account successfully registered.");
    }
}
