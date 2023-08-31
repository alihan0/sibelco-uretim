<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function last10(){
        return  view('archive.last10', ['surveys' => Survey::take(10)->orderBy('id', 'desc')->get()]);
    }
}
