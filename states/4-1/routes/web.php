<?php

use App\Http\Controllers\ChatController;
use App\Models\Message;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chat', function () {
    $messages = Message::all();

    return view('chat', ['messages' => $messages]);
});

Route::post('/chat', [ChatController::class, 'store']);

Route::delete('/messages/{message}', [ChatController::class, 'destroy']);

Route::get('/messages/{message}/edit', [ChatController::class, 'edit']);

Route::patch('/messages/{message}', [ChatController::class, 'update']);
