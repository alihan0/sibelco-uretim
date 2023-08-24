<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    protected $type = "warning";
    protected $message = null;
    protected $status = false;
    
    public function new(){
        return view('facility.new');
    }

    public function save(Request $request){
        if(empty($request->title)){
            $this->message = "Tesis adını girmek zorundasınız.";
        }else{
            $save = Facility::create([
                "title" => trim(ucfirst($request->title)),
                "detail" => trim(ucfirst($request->detail))
            ]);

            if($save){
                $this->type = "success";
                $this->message = "Tesis oluşturuldu";
                $this->status = true;
            }
        }

        return response(["type" => $this->type, "message" => $this->message, "status" => $this->status]);
    }
}
