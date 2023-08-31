<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyDraftSubformAnswer extends Model
{
    use HasFactory;

    protected $table = "survey_draft_subform_answers";

    protected $fillable = [
        'user',
        'key',
        'subform',
        'question',
        'answer',
    ];

    public function Question(){
        return $this->hasOne(FormSubQuestion::class , 'id', 'question');
    }
   
}
