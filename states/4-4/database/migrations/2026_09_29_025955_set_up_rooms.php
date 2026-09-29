<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('rooms')) {
            Schema::create('rooms', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        if (! Schema::hasColumn('messages', 'room_id')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->foreignId('room_id')->default(1)->constrained();
            });
        }
    }

    public function down(): void
    {
        //
    }
};
