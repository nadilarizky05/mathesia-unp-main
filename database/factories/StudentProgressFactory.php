<?php

namespace Database\Factories;

use App\Models\GameCode;
use App\Models\Material;
use App\Models\SubTopic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentProgress>
 */
class StudentProgressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'sub_topic_id' => SubTopic::factory(),
            'game_code_id' => GameCode::factory(),
            'material_id' => Material::factory(),
            'level' => $this->faker->randomElement(['beginner', 'intermediate', 'pro']),
            'is_completed' => $this->faker->boolean(),
            'completed_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'active_section' => $this->faker->numberBetween(1, 5),
            'completed_section' => $this->faker->randomElements(range(1, 4), $this->faker->numberBetween(0, 4)),
            'progress_percent' => $this->faker->numberBetween(0, 100),
            
        ];
    }
}