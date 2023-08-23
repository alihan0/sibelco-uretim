<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    protected $type = "warning";
    protected $message = null;
    protected $status = false;
    public function new(){
        return view('form.new');
    }

    public function save(Request $request){
        $id = 0;
        if(empty($request->title)){
            $this->message = "Bir başlık girmek zorundasınız.";
        }else{
            $form = Form::create([
                "title" => trim(ucfirst($request->title)),
                "detail" => trim(ucfirst($request->detail)),
                "to_emails" => trim($request->email),
                "status" => 1
            ]);
            if($form){
                $this->type = "success";
                $this->message = "Form başarıyla oluşturuldu";
                $this->status = true;
                $id = $form->id;
            }
        }

        return response(["type" => $this->type, "message" => $this->message, "status" => $this->status, "id" => $id]);
    }

    public function all(){
        return view('form.all', ['forms' => Form::all()]);
    }

    public function detail($id){
        return view('form.detail', ['form' => Form::find($id)]);
    }

    public function delete(Request $request){

        if($request->id){
            $find = Form::find($request->id);
            if($find){
                if($find->delete()){
                    return response(["status" => true]);
                }
            }
        }
    }
}
