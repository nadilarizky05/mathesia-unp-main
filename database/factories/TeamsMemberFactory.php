<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeamsMember>
 */
class TeamsMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
      protected $model = \App\Models\TeamsMember::class;

    public function definition(): array
    {
        return [
            'teams_id' => \App\Models\Teams::factory(),
            'name' => $this->faker->name(),
            'role' => $this->faker->jobTitle(),
            'avatar_url' => null,
            'order' => $this->faker->numberBetween(0, 99),
        ];
    }
}