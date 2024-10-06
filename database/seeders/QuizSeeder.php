<?php

namespace Database\Seeders;

use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $quiz = Quiz::create([
            'title' => 'Sample Quiz',
            'description' => 'This is a sample quiz',
        ]);

        $question = $quiz->questions()->create([
            'question_text' => 'What is the capital of France?',
        ]);

        $question->answers()->createMany([
            ['answer_text' => 'Paris', 'is_correct' => true],
            ['answer_text' => 'London', 'is_correct' => false],
            ['answer_text' => 'Berlin', 'is_correct' => false],
        ]);
    }
}
