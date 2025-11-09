<?php

namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FinalTest>
 */
class FinalTestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'material_id' => Material::factory(),
            'question' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['text', 'file', 'multiple_choice']),
            'options' => null,
            'max_score' => $this->faker->numberBetween(5, 20),
            'duration_minutes' => $this->faker->numberBetween(30, 120),
        ];
    }
}