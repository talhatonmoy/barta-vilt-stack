<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserDetail>
 */
class UserDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Array of language names
        $languages = [
            'English',
            'Spanish',
            'French',
            'German',
            'Chinese',
            'Arabic',
            'Hindi',
            'Portuguese',
            'Russian',
            'Japanese'
        ];
        
        return [
            'mobile' => $this->faker->phoneNumber(), // Generates a fake phone number
            'website' => substr($this->faker->url, 0, 50), // Limit to 255 characters
            'facebook' => $this->faker->url(), // Generates another fake URL for Facebook
            'whatsapp' => $this->faker->phoneNumber(), // Generates a fake phone number for WhatsApp
            'linkedin' => $this->faker->url(), // Generates a fake URL for LinkedIn
            'gender' => $this->faker->randomElement(['male', 'female', '3rd gender']), // Random gender
            'date_of_birth' => $this->faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'), // Date in the past, ensuring age is at least 18
            'nick_name' => $this->faker->word(), // Optional nickname with reasonable length
            'primary_lang' => strtolower($this->faker->randomElement($languages)), // Optional language code
            'secondary_lang' => strtolower($this->faker->randomElement($languages)), // Another optional language code
            'favorite_quote' => $this->faker->sentence(10), // Optional favorite quote with up to 10 words
            'current_city' => strtolower($this->faker->city()), // Optional city name
            'user_id' => User::inRandomOrder()->first()->id, // Selects a random existing user

        ];
    }

    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = UserDetail::class;
}
