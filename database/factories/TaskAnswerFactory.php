<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Task;
use App\Models\TaskAnswer;

class TaskAnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaskAnswer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $task = Task::inRandomOrder()->first();
        $question = Question::inRandomOrder()->first();
        $option = QuestionOption::inRandomOrder()->first();

        return [
            'task_id' => $task->id,
            'question_id' => $question->id,
            'option_id' => $option->id,
            'score' => $this->faker->numberBetween(0, 100),
        ];
    }
}
