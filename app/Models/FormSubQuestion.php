<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubQuestion extends Model
{
    use HasFactory;

    protected $table = "form_subform_questions";

    protected $fillable = [
        'subform',
        'align',
        'title',
        'question',
        'status'
    ];

    public function Form(){
        return $this->belongsTo(Form::class, 'form', 'id');
    }
}
