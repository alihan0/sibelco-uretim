<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyDraft extends Model
{
    use HasFactory;

    protected $table = "survey_drafts";

    protected $fillable = [
        "user",
        "key",
        "form",
        "facility",
        "facility_status",
        "status"
    ];
}
