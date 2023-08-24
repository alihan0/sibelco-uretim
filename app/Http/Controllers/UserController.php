<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Sender\Sender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $type = "warning";
    protected $message = null;
    protected $status = false;
    public function new(){
        return view('user.new');
    }

    public function all(){
        return view('user.all', ['users' => User::all()]);
    }

    public function save(Request $request){

        if($request->type == 0){
            $this->message = "Kullanıcı tipini seçin!";
        }elseif(empty($request->name) || empty($request->username) || empty($request->email) || empty($request->phone)){
            $this->message = "Boş alan bırakmayın!";
        }else{
            $name = trim(ucfirst($request->name));
            $username = trim($request->username);
            $email = trim($request->email);
            $phone = trim($request->phone);
            $password = Str::random(10);
            
            $check_username = User::where('username', $username)->first();
            $check_email = User::where('email', $email)->first();
            $check_phone = User::where('phone', $phone)->first();
            
            if ($check_username) {
                $this->message = "Kullanıcı adı daha önce alınmış!";
            } elseif ($check_email) {
                $this->message = "E-posta adresi zaten kayıtlı!";
            } elseif ($check_phone) {
                $this->message = "Telefon numarası zaten kayıtlı!";
            } else {
                $user = User::create([
                    'type' => $request->type,
                    'name' => $name,
                    'username' => $username,
                    'email' => $email,
                    'phone' => $phone,
                    'password' => Hash::make($password)
                ]);
            
                if ($user) {
                    $data = [
                        'name' => $name,
                        'username' => $username,
                        'password' => $password,
                        'accountType' => $request->type
                    ];
                    
                    Sender::email($email, 'Hesabın Oluşturuldu', $data, 'emails.account-created');
                    $this->type = "success";
                    $this->message = "Hesap Oluşturuldu.";
                    $this->status = true;
                }
            }
            
        }

        return response(["type" => $this->type, "message" => $this->message, "status" => $this->status]);
    }

    public function delete(Request $request){
        if($request->id){
            $find = User::find($request->id);
            if($find){
                if($find->delete()){
                    return response(["status" => true]);
                }
            }
        }
    }

    public function change_password(Request $request){
        if($request->id){
            $find = User::find($request->id);
            if($find){
                $password = Str::random(10);
                $find->password = Hash::make($password);
                if($find->save()){
                    $data = [
                        "name" => $find->name,
                        "password" => $password
                    ];
                    Sender::email($find->email, 'Şifren Değiştirildi', $data, 'emails.password-change');
                    return response(["status" => true]);
                }
            }
        }
    }

}
