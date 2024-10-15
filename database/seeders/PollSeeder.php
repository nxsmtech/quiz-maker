<?php
namespace Database\Seeders;

use App\Models\Poll;
use Illuminate\Database\Seeder;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create a poll
        $poll = Poll::create([
            'title' => 'Favorite Programming Language',
            'description' => 'Vote for your favorite programming language!',
            'question' => 'Which programming language do you prefer?',
        ]);

        // Create poll options
        $poll->options()->createMany([
            ['option_text' => 'PHP'],
            ['option_text' => 'JavaScript'],
            ['option_text' => 'Python'],
            ['option_text' => 'Ruby'],
        ]);
    }
}
