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

    public function last3Months() {
        $currentDate = Carbon::now();
        $threeMonthsAgo = $currentDate->subMonths(3);
    
        $surveys = Survey::where('created_at', '>=', $threeMonthsAgo)
                         ->orderBy('created_at', 'desc')
                         ->get();
    
        return view('archive.3month', ['surveys' => $surveys]);
    }

    public function all(){
        return  view('archive.all', ['surveys' => Survey::all()]);
    }

    public function detail($id)
{
    $survey = Survey::with('subformAnswers') // Eager loading ilişkiyi ekler
        ->find($id);

    $groupedSubforms = $survey->subformAnswers
        ->groupBy('subform'); // Subform sütununa göre gruplar

    return view('archive.detail', [
        'survey' => $survey,
        'groupedSubforms' => $groupedSubforms,
    ]);
}
}
