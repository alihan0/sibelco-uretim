<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    use HasFactory;
    
    protected $table = "survey_answers";

    protected $fillable = [
        "user",
        "survey",
        "key",
        "form",
        "question",
        "answer",
        "note",
        "confirm_code",
        "confirmative",
        "file"
    ];

    public function Question(){
        return $this->belongsTo(FormQuestion::class,  'question', 'id');
    }

    public function Confirmative(){
        return $this->belongsTo(User::class,   "confirmative");
    }

    public function Survey(){
        return $this->belongsTo(Survey::class, 'survey', 'id');
    }
}
