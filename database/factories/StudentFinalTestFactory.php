<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentFinalTest>
 */
class StudentFinalTestFactory extends Factory
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
            'material_id' => \App\Models\Material::factory(),
            'started_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'expires_at' => $this->faker->dateTimeBetween('now', '+1 week'),
            'finished_at' => $this->faker->optional()->dateTimeBetween('now', '+2 weeks'),
            'is_submitted' => $this->faker->boolean(),
            'total_score' => $this->faker->optional()->numberBetween(0, 100),
        ];
    }
}