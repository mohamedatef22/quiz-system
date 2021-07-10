<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\user_quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware(['auth', 'room.enrolled']);
        $this->middleware("quiz.nottaken:{$request->route('quiz')}")->except([
            'show', 'result',
        ]);
    }

    public function show(Quiz $quiz)
    {
        return view('quiz.show', compact('quiz'));
    }

    public function take(Quiz $quiz)
    {
        $start = !$quiz->start_at || ($quiz->start_at && $quiz->start_at->isPast());
        $end = $quiz->end_at && $quiz->end_at->isPast();
        if ($end) {
            return redirect()->route('home')->with(['toaster_message' => 'quiz has ended', 'toaster_type' => 'error']);
        } elseif (!$start && $quiz->start_at) {
            return redirect()->route('home')->with(['toaster_message' => 'quiz not started yet', 'toaster_type' => 'info']);
        }
        $quiz->load(['questions.answers']);
        return view('quiz.take', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $start = !$quiz->start_at || ($quiz->start_at && $quiz->start_at->isPast());
        $end = $quiz->end_at && $quiz->end_at->addMinute(2)->isPast(); // add two minuts safe for submition
        if ($end) {
            return redirect()->route('home')->with(['toaster_message' => 'quiz has ended', 'toaster_type' => 'error']);
        } elseif (!$start && $quiz->start_at) {
            return redirect()->route('home')->with(['toaster_message' => 'quiz not started yet', 'toaster_type' => 'info']);
        }
        $quiz->load([
            'questions' => function ($query) {
                $query->select('id', 'quiz_id');
            },
            'questions.answers' => function ($query) {
                $query->where('is_correct', true)->select('id', 'question_id', 'is_correct');
            },
        ]);

        // #FIXME fix multiple choice and if answer has variable grade
        $answerd_questions = $request->input();
        unset($answerd_questions['_token']);
        $grade = 0;
        foreach ($answerd_questions as $question_id => $answer_id) {
            $question = $quiz->questions->find($question_id);
            if ($question) {
                if ($question->answers->contains($answer_id)) {
                    $grade++;
                }
            }
        }
        $user_quiz = user_quiz::where('user_id', Auth::user()->id)->where('quiz_id', $quiz->id)->update([
            'grade' => $grade,
            'ended_at' => now(),
        ]);
        // return $user_quiz;
        return redirect()->route('quiz.show', ['quiz' => $quiz]);
    }

    // utilities

    public static function isQuizTaken($user_id, $quiz_id, $check_dates_too = false, $return_grade = false)
    {
        $is_quiz_taken = user_quiz::where('user_id', $user_id)->where('quiz_id', $quiz_id)->get();
        if ($is_quiz_taken->contains('user_id', $user_id)) {
            if ($return_grade) {
                return $is_quiz_taken[0]->grade;
            }
            if ($check_dates_too &&
                $is_quiz_taken[0]->started_at->diffInSeconds($is_quiz_taken[0]->ended_at) < 60) {
                return false;
            }
            return true;
        }
        return false;
    }

}
