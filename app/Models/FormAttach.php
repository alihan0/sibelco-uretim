<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormAttach extends Model
{
    use HasFactory;

    protected $table = "form_attach";

    protected $fillable = [
        "form",
        "subform",
        "question"
    ];

}
