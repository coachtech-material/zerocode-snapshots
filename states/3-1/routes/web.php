<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chat', function () {
    $messages = [
        ['name' => 'はな', 'body' => 'こんにちは。このチャット、自分で作ったんだって？'],
        ['name' => 'そら', 'body' => 'そう。Laravel という道具で作ったよ'],
        ['name' => 'はな', 'body' => 'すごい、ほんとに動いてる'],
        ['name' => 'そら', 'body' => 'まだ見た目だけだけどね'],
        ['name' => 'はな', 'body' => 'じゃあ記念にひとこと。はじめまして'],
    ];

    return view('chat', ['messages' => $messages]);
});
