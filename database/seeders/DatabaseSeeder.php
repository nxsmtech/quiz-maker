<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@quiz.make-me-rich.net',
            'password' => bcrypt('*w3b7@Yy8Xu@DZ'),
            'is_admin' => true,
        ]);

        $this->call([
            QuizSeeder::class,
            PollSeeder::class
        ]);
    }
}
