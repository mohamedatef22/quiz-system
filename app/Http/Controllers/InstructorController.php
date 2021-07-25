<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'instructor']);
    }

    public function dashboard()
    {
        return view('instructor.dashboard');
    }

    public function showStudents(Room $room)
    {
        $user = Auth::user();
        $rooms = $user->my_rooms()->select('id', 'name')->get();
        // $students = $room->users()->paginate(1);
        if ($room->user_id !== $user->id) {
            return redirect()->route('home')->with([
                'toaster_message' => 'not authrized to get this page',
                'toaster_type' => 'error',
            ]);
        }
        $students = $room->users()->paginate(3);
        // return $students;
        // my_rooms()->with(['users' => function ($query) {
        //     $query->select('first_name', 'last_name', 'username', 'email');
        // }])->get();
        return view('instructor.students.show', compact('room', 'students', 'rooms'));
    }

    public function students()
    {
        $user = Auth::user();
        $room = $user->my_rooms()->first();
        if (!$room) {
            return redirect()->route('dashboard')->with([
                'toaster_message' => 'You don\'t have any room , Craete room and try again',
                'toaster_type' => 'info',
            ]);
        }
        return redirect()->route('students.show', ['room' => $room]);
    }

    public function rooms()
    {
        $rooms = Auth::user()->my_rooms()->latest()->paginate(10);
        // dd($rooms);
        return view('instructor.rooms.index', compact('rooms'));
    }

    public function createRoom()
    {
        return view('instructor.rooms.create');
    }

    public function storeRoom(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'pass' => ['required', 'min:5', 'max:10'],
        ]);

        // #FIXME add condition for instructor only
        $room = Room::create([
            'name' => $validate["name"],
            'password' => $validate["pass"],
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('rooms')->with([
            'toaster_message' => 'Room Created successfuly',
            'toaster_type' => 'success',
        ]);
    }
}
