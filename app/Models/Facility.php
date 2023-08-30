<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $table = "facility";
    protected $fillable = [
        "title",
        "detail"
    ];

    public function Units(){
        return $this->hasMany(Unit::class, 'facility', 'id');
    }
}
