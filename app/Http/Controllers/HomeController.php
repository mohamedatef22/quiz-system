<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\room_user;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        $rooms = Room::latest()->with(['owner' => function ($query) {
            $query->select('id', 'email', 'first_name', 'last_name');
        }])->paginate(10);

        $enrolled = collect();

        if (Auth::check()) {
            $enrolled = room_user::where('user_id', Auth::user()->id)->get('room_id');
        }

        return view('index', compact(['rooms', 'enrolled']));
    }
}
