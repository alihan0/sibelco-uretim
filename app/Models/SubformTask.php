<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubformTask extends Model
{
    use HasFactory;

    protected $table = "subform_tasks";

    protected $fillable = [
        'form_key',
        'subform',
        'status',
    ];

    public function SubForm(){
        return $this->belongsTo(FormSub::class, 'subform', 'id');
    }
}
