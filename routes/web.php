<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/dashboard', [InstructorController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/room/{room}/students', [InstructorController::class, 'showStudents'])->name('students.show');
Route::get('/dashboard/students', [InstructorController::class, 'students'])->name('students');
Route::get('/dashboard/rooms', [InstructorController::class, 'rooms'])->name('rooms');
Route::get('/dashboard/room/create', [InstructorController::class, 'createRoom'])->name('room.create');
Route::post('/dashboard/room/create', [InstructorController::class, 'storeRoom'])->name('room.store');

Route::post('/be/instructor', function () {
    $user = Auth::user();
    $user->role = 'instructor';
    $user->save();

    return redirect()->route('home')->with([
        'toaster_message' => 'You are now Instructor :)',
        'toaster_type' => 'success',
    ]);
})->middleware('auth')->name('be.in');
require __DIR__ . '/auth.php';
