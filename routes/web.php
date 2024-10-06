<?php
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/quiz/{quiz}', [QuizController::class, 'show'])->name('quiz.preview');
