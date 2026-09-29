<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\EnterController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::delete('/messages/{message}', [ChatController::class, 'destroy']);

Route::get('/messages/{message}/edit', [ChatController::class, 'edit']);

Route::patch('/messages/{message}', [ChatController::class, 'update']);

Route::get('/rooms', [RoomController::class, 'index']);

Route::get('/rooms/{room}', [RoomController::class, 'show']);

Route::post('/rooms/{room}', [ChatController::class, 'store']);

Route::get('/enter', [EnterController::class, 'show']);

Route::post('/enter', [EnterController::class, 'store']);
