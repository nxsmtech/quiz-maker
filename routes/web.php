<?php

use App\Http\Controllers\PollController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/quiz/{quiz}', [QuizController::class, 'show'])->name('quiz.preview');
Route::get('/poll/{poll}', [PollController::class, 'show'])->name('poll.preview');
