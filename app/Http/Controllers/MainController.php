<?php

namespace App\Http\Controllers;

use App\Models\ConfimCode;
use App\Models\Facility;
use App\Models\Form;
use App\Models\FormAttach;
use App\Models\FormQuestion;
use App\Models\FormSubQuestion;
use App\Models\Notification;
use App\Models\SubformTask;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyDraft;
use App\Models\SurveyDraftAnswer;
use App\Models\SurveyDraftSubformAnswer;
use App\Models\User;
use App\Sender\Sender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

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

    public function get_admins(Request $request){
        return response(User::whereIN('type', ['ADMIN','BOTH'])->get());
    }

    public function send_confirmation_code(Request $request){
        if($request->admin){
            $admin = User::find($request->admin);
            $soru = FormQuestion::find($request->question);
            if($admin){
                $characters = '0123456789';
                $generatecode = '';

                for ($i = 0; $i < 6; $i++) {
                    $generatecode .= $characters[random_int(0, strlen($characters) - 1)];
                }

                $randcode = ConfimCode::where('code', $generatecode)->first();
                if($randcode){
                    $rand = Str::random(6);
                }else{
                    $rand = $generatecode;
                    ConfimCode::create(["code" => $rand, "status" => 1]);
                }
                
                $message = Auth::user()->name . ", $soru->title için onay istiyor. Onay Kodu: $rand";
                Sender::sms($admin->phone, $message);
            }
        }
        return response(["status" => true]);
    }

    public function control_confirmation_code(Request $request) {
        if ($request->code) {
            $find = ConfimCode::where('code', $request->code)->where('status', 1)->first();
            if ($find) {
                $find->status = 0;
                if ($find->save()) {
                    return response()->json(["statusText" => "İşlem Onaylandı", "ok" => true]);
                }
            } else {
                return response()->json(["statusText" => "Geçersiz Onay Kodu"]);
            }
        }
    }
    
    public function form_save_anket(Request $request){

        if($request->form && $request->tesis){
            $form = Form::find($request->form);
            $tesis = Facility::find($request->tesis);
            $key = Str::random(12);
            if($form && $tesis){
                $save = SurveyDraft::create([
                    "user" => Auth::user()->id,
                    "key" => $key,
                    "form" => $form->id,
                    "facility" => $tesis->id,
                    "facility_status" => $request->tesis_durum,
                    "status" => 1
                ]);
                if($save){
                    return response()->json(["key" => $key, 'draft' => $save->id]);
                }
            }
        }

    }

    public function save_answer(Request $request){
        $save = SurveyDraftAnswer::create([
            "user" => Auth::user()->id,
            "draft" => $request->draft,
            "key" => $request->key,
            "form" => $request->form,
            "question" => $request->soru,
            "answer" => $request->cevap,
            "note" => $request->not,
            "confirm_code" => $request->code,
            "confirmative" => $request->confirmative,
            "file" => $request->file
        ]);

        if($save){
            return response(["type" => "success", "message" => "Yanıtınız kaydedildi"]);
        }else{
            return response(["type" => "danger", "message" => "Yanıtınız kaydedilirken bir hata oluştu"]);
        }
    }

    public function draft_delete(Request $request){
        if($request->draft){
            $draft = SurveyDraft::find($request->draft);
            if($draft){
                SurveyDraftAnswer::where('draft', $draft->id)->delete();
                $draft->delete();

                return response(["type" => "success", "message" => "Taslak Silindi", "status" => true]);
            }
        }
    }


    public function draft_save(Request $request)
    {
        // Draft'ı veritabanından kontrol et
        $draft = SurveyDraft::find($request->draft);

        if (!$draft) {
            return response()->json(['error' => 'Draft not found.'], 404);
        }

        // Yeni bir Survey kaydı oluştur
        $survey = new Survey([
            'user' => $draft->user,
            'key' => $draft->key,
            'form' => $draft->form,
            'unit' => $draft->facility,
            'unit_status' => $draft->facility_status,
            'signature' => $request->signature,
            'status' => 1
        ]);
        $survey->save();

        // SurveyDraftAnswer'ları SurveyAnswer olarak yeniden oluştur
        $draftAnswers = SurveyDraftAnswer::where('draft', $request->draft)->get();
        foreach ($draftAnswers as $draftAnswer) {
            $surveyAnswer = new SurveyAnswer([
                "user" => $draftAnswer->user,
                "survey" => $survey->id,
                "key" => $draftAnswer->key,
                "form" => $draftAnswer->form,
                "question" =>$draftAnswer->question,
                "answer" => $draftAnswer->answer,
                "note" => $draftAnswer->note,
                "confirm_code" => $draftAnswer->confirm_code,
                "confirmative" => $draftAnswer->confirmative
            ]);
            $surveyAnswer->save();
        }

        // Draft ve DraftAnswerları sil
        SurveyDraft::where('id', $request->draft)->delete();
        SurveyDraftAnswer::where('draft', $request->draft)->delete();

        return response()->json(['type'=>'success','message' => 'Form Kaydedildi','status'=>true]);
    }

    public function find_subform(Request $request){
        $find = FormAttach::where('form', $request->formId)->where('question', $request->questionNumber)->first();
        if($find){
            $task = SubformTask::create([
                "form_key" => $request->key,
                "subform" => $find->subform,
                "status" => 1
            ]);
            if($task){
                return response(["status" => true]);
            }
        }
    }

    public function find_subform_task(Request $request){
        $find = SubformTask::where('form_key', $request->key)->where('status', 1)->with('SubForm')->get();
        if($find){
            return response(["subforms" => $find]);
        }
    }

    public function find_subform_questions(Request $request){
        $find = FormSubQuestion::where('subform', $request->subformId)->get();

        return response(["questions" => $find]);
    }

    public function save_subform_answers(Request $request){

        foreach ($request->formData as $question => $answer) {
            
            $soru =  str_replace('soru_', '', $question);
           

            $surveyAnswer = new SurveyDraftSubformAnswer();
            $surveyAnswer->user = Auth::user()->id;
            $surveyAnswer->key = $request->key;
            $surveyAnswer->subform = $request->subformId;
            $surveyAnswer->question = $soru;
            $surveyAnswer->answer = $answer;
            $surveyAnswer->save();
        }
    

        return response(["status" => true]);
    }
}
