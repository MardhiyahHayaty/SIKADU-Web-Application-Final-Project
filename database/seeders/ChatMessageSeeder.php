<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Contoh data dummy percakapan
        ChatMessage::create([
            'from_id' => 1,
            'to_id' => 149828388474070,
            'body' => 'Halo, apa kabar?',
        ]);

        ChatMessage::create([
            'from_id' => 149828388474070,
            'to_id' => 1,
            'body' => 'Hai, saya baik. Terima kasih!',
        ]);
    }
}
