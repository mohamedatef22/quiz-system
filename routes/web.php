<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/room/{room}', [RoomController::class, 'show'])->name('room.show');

Route::post('/room/{room}', [RoomController::class, 'enroll'])->name('room.enroll');

Route::get('/quiz/{quiz}', [QuizController::class, 'show'])->name('quiz.show');

Route::get('/quiz/take/{quiz}', [QuizController::class, 'take'])->name('quiz.take');

Route::post('/quiz/submit/{quiz}', [QuizController::class, 'submit'])->name('quiz.submit');

// Route::get('/quiz/result/{quiz}', [QuizController::class, 'result'])->name('quiz.result');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
