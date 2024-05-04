<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Task;
use App\Models\TaskAnswer;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->generateUsers();

        $this->generateQuestions();

        $this->generateTasks();
    }

    protected function generateUsers(): void
    {
        $users = json_decode(file_get_contents(database_path('users.json')), true);

        foreach (Arr::shuffle($users) as $user) {
            User::query()->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'gender' => $user['gender'],
                'birthdate' => $user['birthdate'],
                'email_verified_at' => random_int(0, 1) ? now() : null,
                'password' => bcrypt('password'),
                'remember_token' => Str::random(40),
            ]);
        }
    }

    protected function generateQuestions(): void
    {
        $data = json_decode(file_get_contents(database_path('data.json')), true);

        foreach ($data['categories'] as $category) {
            Category::query()->create([
                'id' => $category['id'],
                'name' => $category['name'],
            ]);
        }

        foreach ($data['questions'] as $question) {
            $questionModel = Question::query()->create([
                'id' => $question['id'],
                'category_id' => $question['category_id'],
                'name' => $question['name'],
            ]);

            foreach ($question['options'] as $option) {
                QuestionOption::query()->create([
                    'id' => $option['id'],
                    'question_id' => $questionModel->id,
                    'name' => $option['name'],
                    'is_correct' => $option['is_correct'],
                ]);
            }
        }
    }

    protected function generateTasks(): void
    {
        $tasksCount = 50;
        $questionsCount = 10;
        $minUserId = User::min('id');
        $maxUserId = User::max('id');
        $userIds = [];

        for ($i = 0; $i < $tasksCount; $i++) {
            $userIds[$i] = mt_rand($minUserId, $maxUserId);
        }

        foreach ($userIds as $key => $userId) {
            $task = Task::query()->create([
                'user_id' => $userId,
                'max_score' => $questionsCount,
                'total_score' => 0,
                'start_time' => Carbon::now(),
                'end_time' => Carbon::now()->addHour(),
            ]);

            $questions = Question::inRandomOrder()->limit($questionsCount)->get();

            foreach ($questions as $question) {
                if ($question->id % 2 == 0 || $key % 5 == 0) {
                    $option = $question->options()->where('is_correct', 1)->first();
                } else {
                    $option = $question->options()->inRandomOrder()->first();
                }

                TaskAnswer::query()->create([
                    'task_id' => $task->id,
                    'question_id' => $question->id,
                    'option_id' => $option->id,
                    'score' => $option->is_correct ? 1 : 0,
                ]);
            }

            $task->update([
                'total_score' => $task->taskAnswers()->sum('score'),
            ]);
        }
    }
}
