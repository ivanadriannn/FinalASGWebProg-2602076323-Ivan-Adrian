<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Message::create([
            'sender_id' => 1,
            'receiver_id' => 2,
            'content' => 'Hello friend',
        ]);

        Message::create([
            'sender_id' => 2,
            'receiver_id' => 1,
            'content' => 'Hello friend response',
        ]);
    }
}
