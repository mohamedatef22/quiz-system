<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\room_user;
use App\Models\user_quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('room.enrolled');
        $this->middleware('quiz.nottaken');
    }

    public function show(Quiz $quiz)
    {
        // $room_id = $quiz->room_id;
        // $quiz_id = $quiz->id;
        // $user_id = Auth::user()->id;
        // $is_enrolled_in_room = room_user::where('user_id', $user_id)->where('room_id', $room_id)->get();
        // if (!$is_enrolled_in_room->contains('user_id', $user_id)) {
        //     return redirect()->route('home')->with('msg', 'not authrized to get show quiz');
        // }
        // $is_quiz_taken = user_quiz::where('user_id', $user_id)->where('quiz_id', $quiz_id)->get();
        // if ($is_quiz_taken->contains('user_id', $user_id)) {
        //     return redirect()->back()->with('msg', 'can\'t take quiz again');
        // }
        return view('quiz.show', compact('quiz'));
    }

    public function take(Quiz $quiz)
    {

    }
}
