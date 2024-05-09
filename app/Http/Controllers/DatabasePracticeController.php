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

    /**
     * Display list of tasks with max score.
     */
    public function practice7()
    {
        $tasks = DB::table('tasks')
            ->selectRaw('user_id, MAX(total_score) AS max_user_score')
            ->addSelect([
                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('users.id', 'tasks.user_id'),

                // 'user_email' => DB::table('users')
                //     ->select('email')
                //     ->whereColumn('users.id', 'tasks.user_id')
            ])
            ->groupBy('user_id')
            ->orderByDesc('max_user_score')
            ->get();

        return view('table', $this->data($tasks));
    }

    /**
     * List users who have born in November, 2007
     * id, name, birthdate
     */
    public function practice8()
    {
        $users = DB::table('users')
            ->select('id', 'name', 'birthdate')
            // ->whereDate('birthdate', '2007-11-28')
            ->whereYear('birthdate', 2007)
            ->whereMonth('birthdate', 11)
            ->get();

        return view('table', $this->data($users));
    }

    /**
     * List number of verified and not verified users
     */
    public function practice9()
    {
        $verifiedCount = DB::table('users')
            ->whereNotNull('email_verified_at') // where `email_verified_at` is not null
            ->count();

        $notVerifiedCount = DB::table('users')
            ->whereNull('email_verified_at')    // where `email_verified_at` is null
            ->count();

        return [
            'email_verified_count' => $verifiedCount,
            'email_not_verified_count' => $notVerifiedCount,
        ];
    }

    /**
     * Display youngest and oldest users
     */
    public function practice10()
    {
        DB::table('users')->max('birthdate'); // youngest
        DB::table('users')->min('birthdate'); // oldest

        $youngestUser = DB::table('users')
            ->select('id', 'name', 'birthdate')
            ->latest('birthdate') // order by `birthdate` desc
            ->first();

        $oldestUser = DB::table('users')
            ->select('id', 'name', 'birthdate')
            ->oldest('birthdate') // order by `birthdate` asc
            ->first();

        return [
            'youngest_user' => $youngestUser,
            'oldest_user' => $oldestUser,
        ];
    }
}
