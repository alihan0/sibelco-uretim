<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = "units";

    protected $fillable = [
        "facility",
        "title",
        "detail"
    ];

    public function Facility(){
        return $this->belongsTo(Facility::class, 'facility' ,'id');
    }
}
