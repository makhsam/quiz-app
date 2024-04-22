<?php

namespace App\Http\Controllers;

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

    public function practice4()
    {
        return view('table', $this->data());
    }

    public function practice5()
    {
        return view('table', $this->data());
    }

    public function practice6()
    {
        return view('table', $this->data());
    }

    public function practice7()
    {
        return view('table', $this->data());
    }
}
