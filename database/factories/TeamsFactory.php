<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teams>
 */
class TeamsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Teams::class;
    public function definition(): array
    {
       $name = $this->faker->company();
        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.Str::random(4),
            'description' => $this->faker->sentence(12),
        ];
    }
}