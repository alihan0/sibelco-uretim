<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSub extends Model
{
    use HasFactory;

    protected $table = "form_subforms";

    protected $fillable = [
        'form',
        'title',
        'status'
    ];
}
