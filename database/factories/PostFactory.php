<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'post_body' => fake()->paragraph(3, true),
            'excerpt' => fake()->text(200),
            'user_id' => User::inRandomOrder()->first()->id, // Selects a random existing user
        ];
    }
}
