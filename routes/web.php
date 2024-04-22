<?php

use App\Http\Controllers\DatabasePracticeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('database/practice/1', [DatabasePracticeController::class, 'practice1']);
Route::get('database/practice/2', [DatabasePracticeController::class, 'practice2']);
Route::get('database/practice/3', [DatabasePracticeController::class, 'practice3']);
Route::get('database/practice/4', [DatabasePracticeController::class, 'practice4']);
Route::get('database/practice/5', [DatabasePracticeController::class, 'practice5']);
Route::get('database/practice/6', [DatabasePracticeController::class, 'practice6']);
Route::get('database/practice/7', [DatabasePracticeController::class, 'practice7']);
