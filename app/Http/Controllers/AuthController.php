<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $type = "warning";
    protected $message = null;
    protected $status = false;

    public function login(){
        return view('auth.login');
    }

    public function do_login(Request $request){
        if(empty($request->username) || empty($request->password) ){
            $this->message = "Kullanıcı adı ve şifrenizi girin!";
        }else{
            if(Auth::attempt(["username"=>$request->username, "password"=>$request->password])){
                $this->type = "success";
                $this->message = "Giriş Başarılı!";
                $this->status = true;
                $user = Auth::user();
                if ($user->type == 'ADMIN') {
                    Session::put('screen', 'admin');
                } elseif ($user->type == 'USER') {
                    Session::put('screen', 'BOTH');
                } elseif ($user->type == 'both') {
                    Session::put('screen', Auth::user()->default_screen);
                }

                
            }else{
                $this->message = "Kullanıcı adı ya da şifre hatalı!";
            }
        }
        return response(["type" => $this->type, "message" => $this->message, "status" => $this->status]);
    }

    public function logout(Request $request) {
        Auth::logout();
        Session::flush();
        return redirect('/');
      }
}
