<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $table = 'surveys';

    protected $fillable = [
        "user",
        "key",
        "form",
        "unit",
        "unit_status",
        "signature",
        "image",
        "status",
    ];


    public function Form(){
        return $this->hasOne(Form::class, 'id', 'form');
    }

    public function User(){
        return $this->hasOne(User::class, 'id', 'user');
    }

    public function Unit(){
        return $this->hasOne(Unit::class, 'id', 'unit');
    }

    public function Answer(){
        return $this->hasMany(SurveyAnswer::class, 'survey', 'id');
    }

    

}
