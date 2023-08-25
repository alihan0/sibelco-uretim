<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormQuestion;
use App\Models\Notification;
use App\Models\User;
use App\Sender\Sender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    public function index(){
        if(Session::has('screen')){
            if(Session::get('screen') == "admin"){
                return view('main.dashboard');
            }else{
                return redirect('/staff');
            }
        }else{
            return redirect('/auth/logout');
        }
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

    public function get_question(Request $request){
        $form = Form::find($request->formid);
        $soru = FormQuestion::where('form', $form->id)->where('align', $request->soru)->first();

        return response(["form" => $form, "soru" => $soru]);
    }

    public function set_defatult_screen(Request $request){
        if($request->screen && $request->user){
            $user = User::find($request->user);
            if($user){
                $user->default_screen = $request->screen;
                if($user->save()){
                    Sender::notification($request->user, "Varsayılan Ekran Değiştirildi", "Oturum açtığınızda yönlendirileceğiniz varsayılan ekran tercihiniz <code>$request->screen</code> olarak değiştirildi");
                    return response(["status" => true]);
                }
            }
        }
    }
}
