<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Form;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function forms(){
        return view('staff.forms', ['forms' => Form::all(), 'facilities' => Facility::with('Units')->get()]);
    }
}
