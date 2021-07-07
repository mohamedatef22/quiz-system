<?php

namespace App\Http\Middleware;

use App\Models\room_user;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureRoomEnrolled
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
        $quiz = $request->route('quiz');
        $room_id = $quiz->room_id;
        $user_id = Auth::user()->id;
        $is_enrolled_in_room = room_user::where('user_id', $user_id)->where('room_id', $room_id)->get();
        if (!$is_enrolled_in_room->contains('user_id', $user_id)) {
            return redirect()->route('home')->with(['toaster_message' => 'not authrized to get this quiz', 'toaster_type' => 'error']);
        }
        $request->merge(['quiz' => $quiz]);
        return $next($request);
    }
}
