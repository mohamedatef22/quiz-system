<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Instructor
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
        $user = Auth::user();
        if ($user->role !== 'instructor') {
            return redirect()->route('home')->with([
                'toaster_message' => 'Not Authorized to get this page',
                'toaster_type' => 'error',
            ]);
        }
        return $next($request);
    }
}
