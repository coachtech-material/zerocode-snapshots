<?php

namespace App\Http\Controllers;

use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        if (session('nickname') === null) {
            return redirect('/enter');
        }

        $rooms = Room::all();

        return view('rooms', ['rooms' => $rooms]);
    }

    public function show(Room $room)
    {
        if (session('nickname') === null) {
            return redirect('/enter');
        }

        $messages = $room->messages;

        return view('chat', ['room' => $room, 'messages' => $messages]);
    }
}
