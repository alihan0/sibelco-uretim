<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Unit;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    protected $type = "warning";
    protected $message = null;
    protected $status = false;

    public function new(){
        return view('facility.new');
    }
    public function all(){
        return view('facility.all', ['facilities' => Facility::all()]);
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

    public function rename(Request $request){
        if($request->id){
            $find = Facility::find($request->id);
            if($find){
                $find->title = trim(ucfirst($request->title));
                if($find->save()){
                    return response(["status" => true]);
                }
            }
        }
    }

    public function delete(Request $request){
        if($request->id){
            $find = Facility::find($request->id);
            if($find){
                if($find->delete()){
                    return response(["status" => true]);
                }
            }
        }
    }


    public function new_unit(){
        return view('facility.new-unit', ['facilities' => Facility::all()]);
    }
    public function all_unit(){
        return view('facility.all-unit', ['units' => Unit::all()]);
    }

    public function save_unit(Request $request){
        if($request->facility == 0){
            $this->message = "Birimin bağlı olduğu tesisi seçin";
        }elseif(empty($request->title)){
            $this->message = "Birim adını girmek zorundasınız.";
        }else{
            $save = Unit::create([
                "facility" => $request->facility,
                "title" => trim(ucfirst($request->title)),
                "detail" => trim(ucfirst($request->detail))
            ]);

            if($save){
                $this->type = "success";
                $this->message = "Birim oluşturuldu";
                $this->status = true;
            }
        }

        return response(["type" => $this->type, "message" => $this->message, "status" => $this->status]);
    }

    public function rename_unit(Request $request){
        if($request->id){
            $find = Facility::find($request->id);
            if($find){
                $find->title = trim(ucfirst($request->title));
                if($find->save()){
                    return response(["status" => true]);
                }
            }
        }
    }

    public function delete_unit(Request $request){
        if($request->id){
            $find = Facility::find($request->id);
            if($find){
                if($find->delete()){
                    return response(["status" => true]);
                }
            }
        }
    }
}
