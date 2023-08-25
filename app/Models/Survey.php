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
        "facility",
        "facility_status",
        "signature",
        "image",
        "status",
    ];
}
