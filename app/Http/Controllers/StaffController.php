<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function forms(){
        return view('staff.forms');
    }
}
