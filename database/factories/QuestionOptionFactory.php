<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Question;
use App\Models\QuestionOption;

class QuestionOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuestionOption::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $question = Question::inRandomOrder()->first();
        return [
            'question_id' => $question->id,
            'name' => $this->faker->name(),
            'is_correct' => $this->faker->boolean(),
        ];
    }
}
