<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        Room::firstOrCreate(['name' => 'おしゃべり']);
        Room::firstOrCreate(['name' => 'メモ']);
        Room::firstOrCreate(['name' => 'れんらく']);
    }
}
