<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabasePracticeController extends Controller
{
    public function practiceX()
    {
        return view('table', $this->data());
    }

    /**
     * Get random questions, 2-questions from each category
     */
    public function practice1()
    {
        $questions = [];
        $categories = DB::table('categories')->get();

        foreach ($categories as $category) {
            $questions = DB::table('questions')
                ->select('id', 'category_id', 'name')
                ->where('category_id', $category->id)
                ->inRandomOrder()
                ->limit(2)
                ->get()
                ->merge($questions);
        }

        return view('table', $this->data($questions));
    }

    /**
     * Get users with total_score
     */
    public function practice2()
    {
        $tasks = DB::table('tasks')
            ->select('id', 'user_id', 'total_score')
            ->addSelect([
                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('users.id', 'tasks.user_id')
                    ->limit(1)
            ])
            ->orderBy('total_score', 'desc')
            ->get();

        return view('table', $this->data($tasks));
    }

    /**
     * Get questions with their correct options
     */
    public function practice3()
    {
        $questions = DB::table('questions')
            ->select('id', 'name')
            ->addSelect([
                'correct_option_name' => DB::table('question_options')
                    ->select('name')
                    ->where('is_correct', true)
                    ->whereColumn('question_options.question_id', 'questions.id')
                    ->limit(1)
            ])
            ->where('category_id', 1)
            ->get();

        return view('table', $this->data($questions));
    }

    /**
     * 1. Get number of questions in category "Mathematics"
     */
    public function practice4()
    {
        $category = DB::table('categories')->where('id', 1)->first();

        $questionsCount = DB::table('questions')
            ->where('category_id', $category->id)
            ->count();

        return [
            'category_name' => $category->name,
            'questions_count' => $questionsCount,
        ];
    }

    /**
     * 2. Get list of categories with questions_count
     */
    public function practice5()
    {
        $categories = DB::table('categories')
            ->select('name')
            ->addSelect([
                'questions_count' => DB::table('questions')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('questions.category_id', 'categories.id')
            ])
            ->get();

        return $categories;
    }

    /**
     * 3. Get list of questions with options in "Geography" category
     */
    public function practice6()
    {
        $questions = Question::with('options:id,question_id,name')
            ->select('id', 'name')
            ->where('category_id', 5)
            ->get();

        return $questions;
    }

    public function practice7()
    {
        return view('table', $this->data());
    }
}
