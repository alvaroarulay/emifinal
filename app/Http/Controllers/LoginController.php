<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    //
    public function show()
    {
        if(Auth::check()){
            return redirect()->route('home.index');
        }
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        
        $credentials = $request->getCredentials();
        $activo = User::select('condicion')->where('username','=',$request->username)->first();
        $password = User::select('password')->where('username','=',$request->username)->first();
        
        if($password==null){
            return redirect()->route("login.show")->withErrors(['name' => trans('El usuario no existe')]);   
        }elseif(Hash::check($request->password,$password->password)){
            if($activo == null){
                return redirect()->route("login.show")->withErrors(['name' => trans('El usuario no existe')]);       
            }elseif ($activo->condicion == 0 ){
                return redirect()->route("login.show")->withErrors(['name' => trans('El usuario esta deshabilitado')]);
            }
            $user = Auth::getProvider()->retrieveByCredentials($credentials);
                    Auth::login($user);
                    return $this->authenticated($request, $user);
        }
        else{
            return redirect()->route("login.show")->withErrors(['password' => trans('Contraseña Incorrecta!!!')]);
        }
        /*if(!Auth::validate($credentials)):
            //dd('error');
           //return redirect()->to('login')->withErrors(trans('auth.failed'), 'login');
          return   redirect()->route("login.show")->withErrors(['name' => trans($request),'password'=>trans('auth.password')]);
          //$this->username() => [trans('auth.failed')];
        endif;*/
    }

    protected function authenticated(Request $request, $user) 
    {
        return redirect()->route('home.index');
    }
}
