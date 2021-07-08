<?php

namespace App\Http\Middleware;

use App\Http\Controllers\QuizController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureQuizNotTaken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $quiz_id)
    {
        $user_id = Auth::user()->id;
        if (QuizController::isQuizTaken($user_id, $quiz_id, true)) {
            return redirect()->route('home')->with(['toaster_message' => 'can\'t take quiz again', 'toaster_type' => 'warning']);
        }
        return $next($request);
    }
}
