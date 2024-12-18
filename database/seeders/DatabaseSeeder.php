<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Message;
use App\Models\Post;
use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(98)->create();
        // UserDetail::factory(100)->create();
        // Post::factory('300')->create();
        
        Message::factory('190')
        ->state(new Sequence(
            ['sender_id' => 1],
            ['sender_id' => 201]
        ))
        ->state(new Sequence(
            ['receiver_id' => 201],
            ['receiver_id' => 1],
        ))
        ->sequence(function(Sequence $sequence){
            return [
                'body' => "Message {$sequence->index}",
                'created_at' => now()->subYear()->addHour($sequence->index)
            ];
        })
        ->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
