<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

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
}
