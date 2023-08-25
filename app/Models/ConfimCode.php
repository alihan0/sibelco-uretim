<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfimCode extends Model
{
    use HasFactory;

    protected $table = "confirm_codes";

    protected $fillable = [
        "code",
        "status"
    ];
}
