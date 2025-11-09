<?php

namespace Database\Factories;

use App\Models\GameCode;
use App\Models\SubTopic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
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
            'game_code_id' => GameCode::factory(),
            'title' => 'Materi ' . $this->faker->word(),
            'level' => $this->faker->randomElement(['beginner', 'intermediate', 'pro']),
            'content' => $this->faker->paragraph(5),
            'video_url' => 'https://example.com/video/' . $this->faker->slug(),
            
        ];
    }
}