<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Sender\Sender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    public function index(){
        return view('main.dashboard');
    }

    public function notification_read(Request $reqeust){

        if($reqeust->id){
            $find = Notification::find($reqeust->id);
            if($find){
                $find->status = 0;
                if($find->save()){
                    return response(["status" => true]);
                }
            }
        }

    }

    public function change_password(Request $request){
        if($request->id){
            $find = User::find($request->id);
            if($find){
                $find->password = Hash::make($request->password);
                if($find->save()){
                    $data = [
                        "name" => $find->name,
                        "password" => $request->password
                    ];
                    Sender::email($find->email, 'Şifren Değiştirildi', $data, 'emails.password-change');
                    return response(["status" => true]);
                }
            }
        }
    }

    public function switch_screen(Request $request){
        Session::put('screen', $request->screen);
        return response(["status" => true]);
    }
}
