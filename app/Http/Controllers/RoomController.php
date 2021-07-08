<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\room_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{

    public function show(Room $room)
    {
        // return $room;
        $enrolled = false;
        if (Auth::check()) {
            $enrolled = !room_user::where('user_id', Auth::user()->id)
                ->where('room_id', $room->id)
                ->get('room_id')->isEmpty();
        }
        // dd($enrolled);
        return view('room.show', compact(['room', 'enrolled']));
    }

    public function enroll(Request $request, Room $room)
    {
        $validate = $request->validate([
            'password' => 'required',
        ]);

        if ($room->password === $request->password) {
            $is_enrolled = room_user::where('user_id', Auth::user()->id)
                ->where('room_id', $room->id)
                ->get('room_id')->isEmpty();
            if ($is_enrolled) {
                room_user::create([
                    'user_id' => Auth::user()->id,
                    'room_id' => $room->id,
                ]);
                $room->students_number++;
                $room->save();
                return redirect()->back()->with(['toaster_message' => 'enrolled successfuly', 'toaster_type' => 'success']);
            } else {
                return redirect()->back()->with(['toaster_message' => 'enrolled failed already enrolled', 'toaster_type' => 'error']);
            }
        }

        return redirect()->back()->with(['toaster_message' => 'wrong password', 'toaster_type' => 'error'])->withInput();
    }

    // utilities
    public static function isRoomEnrolled($room_id, $user_id)
    {
        $is_enrolled_in_room = room_user::where('user_id', $user_id)->where('room_id', $room_id)->get();
        if ($is_enrolled_in_room->contains('user_id', $user_id)) {
            return true;
        }
        return false;
    }
}
