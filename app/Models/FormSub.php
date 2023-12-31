<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSub extends Model
{
    use HasFactory;

    protected $table = "form_subforms";

    protected $fillable = [
        'title',
        'status'
    ];

    public function Questions(){
        return $this->hasMany(FormSubQuestion::class, 'subform', 'id');
    }
}
