<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function store(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required',
            'body' => 'required',
        ], [
            'name.required' => '名前を入力してください',
            'body.required' => 'メッセージを入力してください',
        ]);

        Message::create([
            'name' => $validated['name'],
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
