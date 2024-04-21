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

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->generateQuestions();

        User::factory(10)->create();
        // Category::factory(10)->create();
        // Question::factory(50)->create();
        // QuestionOption::factory(150)->create();
        // Task::factory(10)->create();
        // TaskAnswer::factory(50)->create();

        $this->generateTasks();
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
        $questionsCount = 10;

        foreach (User::all() as $user) {
            $task = Task::query()->create([
                'user_id' => $user->id,
                'max_score' => $questionsCount,
                'total_score' => 0,
                'start_time' => Carbon::now(),
                'end_time' => Carbon::now()->addHour(),
            ]);

            $questions = Question::inRandomOrder()->limit($questionsCount)->get();

            foreach ($questions as $question) {
                if ($question->id % 2 == 0 || $user->id % 5 == 0) {
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
