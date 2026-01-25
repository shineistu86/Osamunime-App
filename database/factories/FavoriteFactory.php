<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Favorite>
 */
class FavoriteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'anime_id' => $this->faker->randomNumber(4),
            'title' => $this->faker->sentence,
            'image_url' => $this->faker->imageUrl,
            'score' => $this->faker->randomFloat(1, 0, 10),
            'status' => $this->faker->randomElement(['Watching', 'Completed', 'Plan to Watch']),
            'notes' => $this->faker->optional()->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
