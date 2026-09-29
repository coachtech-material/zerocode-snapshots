<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        Message::create(['name' => 'はな', 'body' => 'こんにちは！このチャット、自分で作ったんだって？']);
        Message::create(['name' => 'そら', 'body' => 'そう。Laravel っていう道具で作ったよ']);
        Message::create(['name' => 'はな', 'body' => 'すごい、ほんとに動いてる']);
        Message::create(['name' => 'そら', 'body' => 'メッセージはデータベースに残るから、消えないよ']);
        Message::create(['name' => 'はな', 'body' => 'じゃあ記念にひとこと。はじめまして！']);
    }
}
