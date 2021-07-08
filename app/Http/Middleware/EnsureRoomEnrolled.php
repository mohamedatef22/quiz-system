<?php

namespace App\Http\Middleware;

use App\Http\Controllers\RoomController;
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
    public function handle(Request $request, Closure $next, $room_id = null)
    {
        $user_id = Auth::user()->id;
        if (!$room_id) {
            $room_id = $request->route('quiz')->room_id;
        }
        if (!RoomController::isRoomEnrolled($room_id, $user_id)) {
            return redirect()->route('home')->with(['toaster_message' => 'not authrized to get this quiz', 'toaster_type' => 'error']);
        }
        return $next($request);
    }
}
