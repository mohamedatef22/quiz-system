<?php

namespace App\Http\Middleware;

use App\Models\user_quiz;
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
    public function handle(Request $request, Closure $next)
    {
        return app(EnsureRoomEnrolled::class)->handle($request, function ($request) use ($next) {
            $user_id = Auth::user()->id;
            $quiz_id = $request->quiz->id;
            $is_quiz_taken = user_quiz::where('user_id', $user_id)->where('quiz_id', $quiz_id)->get();
            if ($is_quiz_taken->contains('user_id', $user_id)) {
                return redirect()->back()->with('msg', 'can\'t take quiz again');
            }
            return $next($request);
        });
    }
}
