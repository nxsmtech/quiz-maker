<?php

namespace App\Livewire;

use App\Models\Question;
use Livewire\Component;
use App\Models\Quiz;

class QuizPreview extends Component
{
    public Quiz $quiz;
    public ?Question $currentQuestion;
    public ?int $selectedAnswer = null;
    public bool $started = false;

    public function startQuiz()
    {
        $this->started = true;
        $this->currentQuestion = $this->quiz->questions->sortBy('order_nr')->first();
    }

    public function selectAnswer($answerId)
    {
        $this->selectedAnswer = $answerId;
    }

    public function nextQuestion()
    {
        $this->selectedAnswer = null;
        $nextQuestion = $this->quiz->questions
            ->sortBy('order_nr')
            ->firstWhere('order_nr', '>', $this->currentQuestion->order_nr);

        if ($nextQuestion) {
            $this->currentQuestion = $nextQuestion;
        } else {
            $this->currentQuestion = null; // No more questions, show final message
        }
    }

    public function render()
    {
        return view('livewire.quiz-preview');
    }
}
