<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Question;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $category = Category::inRandomOrder()->first();

        return [
            'category_id' => $category->id,
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
        ];
    }
}
