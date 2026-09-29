<?php

use App\Models\Message;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chat', function () {
    $messages = Message::all();

    return view('chat', ['messages' => $messages]);
});
