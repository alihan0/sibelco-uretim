<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $table = "forms";

    protected $fillable = [
        'title',
        'detail',
        'to_emails',
        'status'
    ];


    public function Questions(){
        return $this->hasMany(FormQuestion::class, 'form', 'id');
    }
}
