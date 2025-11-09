<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubTopic>
 */
class SubTopicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'topic_id' => Topic::factory(),
            'title' => 'Pecahan ' . $this->faker->word(),
            'description' => 'Pemahaman tentang pecahan ' . $this->faker->word(),
            'thumbnail_url' => 'https://placehold.co/300x200',
        ];
    }
}