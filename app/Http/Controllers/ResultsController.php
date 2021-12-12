<?php

namespace App\Http\Controllers;

use App\Classroom;

class ResultsController extends Controller
{
    public function showResultsOfEndedClass()
    {

        $results = Classroom::select('id', 'subject')->with([
            'result' => function ($query) {
                $query->select('id', 'student_id', 'class_id', 'total_mark', 'attained_mark')
                    ->where('student_id', auth()->user()->id);
            }
        ])->onlyTrashed()->get();

        return $results;
    }
}
