<?php

namespace Database\Factories;

use App\Models\SubTopic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameCode>
 */
class GameCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sub_topic_id' => SubTopic::factory(),
            // 'code' => strtoupper($this->faker->lexify('??###')),
            'code' => strtoupper($this->faker->unique()->regexify('[A-Z]{2}[0-9]{3}')),

            'level' => $this->faker->randomElement(['beginner', 'intermediate', 'pro']),
            'description' => $this->faker->sentence(6),
            'game_url' => 'https://example-game.com/' . $this->faker->slug(),
        ];
    }
}
