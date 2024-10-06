<?php

namespace App\Http\Controllers;

use App\Models\Quiz;

class QuizController extends Controller
{
    public function show(Quiz $quiz)
    {
        return view('components.quiz-preview', ['quiz' => $quiz]);
    }
}
