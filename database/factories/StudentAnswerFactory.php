<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentAnswer>
 */
class StudentAnswerFactory extends Factory
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
            'material_section_id' => \App\Models\MaterialSections::factory(),
            'field_name' => $this->faker->randomElement([
                'wacana', 'masalah', 'berpikir_soal_1', 'berpikir_soal_2',
                'rencanakan', 'selesaikan', 'periksa', 'kerjakan_1', 'kerjakan_2'
            ]),
            'answer_text' => $this->faker->optional()->paragraph(),
            'answer_file' => $this->faker->optional()->filePath(),
        ];
    }
}