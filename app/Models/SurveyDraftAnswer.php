<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyDraftAnswer extends Model
{
    use HasFactory;

    protected $table = "survey_draft_answers";

    protected $fillable = [
        "user",
        "draft",
        "form",
        "key",
        "question",
        "answer",
        "note",
        "confirm_code",
        "confirmative",
        "file"
    ];

}
