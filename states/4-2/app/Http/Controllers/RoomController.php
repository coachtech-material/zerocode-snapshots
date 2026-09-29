<?php

namespace App\Http\Controllers;

use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();

        return view('rooms', ['rooms' => $rooms]);
    }

    public function show(Room $room)
    {
        $messages = $room->messages;

        return view('chat', ['room' => $room, 'messages' => $messages]);
    }
}
