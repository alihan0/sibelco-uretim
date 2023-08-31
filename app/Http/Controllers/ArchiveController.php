<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ArchiveController extends Controller
{
    public function last10(){
        return  view('archive.last10', ['surveys' => Survey::take(10)->orderBy('id', 'desc')->get()]);
    }

    public function month(){
        $currentDate = Carbon::now();
        $currentMonth = $currentDate->month;
        $currentYear = $currentDate->year;

        $surveys = Survey::whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $currentMonth)
                        ->orderBy('id', 'desc')
                        ->get();

        return view('archive.month', ['surveys' => $surveys]);
    }
}