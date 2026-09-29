<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function store(Request $request, Room $room)
    {
        if (session('nickname') === null) {
            return redirect('/enter');
        }

        $validated = $request->validate([
            'body' => 'required',
        ], [
            'body.required' => 'メッセージを入力してください',
        ]);

        Message::create([
            'name' => session('nickname'),
            'body' => $validated['body'],
            'room_id' => $room->id,
        ]);

        return redirect('/rooms/' . $room->id);
    }

    public function edit(Message $message)
    {
        return view('edit', ['message' => $message]);
    }

    public function update(Request $request, Message $message)
    {
        $validated = $request->validate([
            'body' => 'required',
        ], [
            'body.required' => 'メッセージを入力してください',
        ]);

        $message->update($validated);

        return redirect('/rooms/' . $message->room_id);
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect('/rooms/' . $message->room_id);
    }
}
