<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentFinalTestAnswer>
 */
class StudentFinalTestAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

        'student_final_test_id' => \App\Models\StudentFinalTest::factory(),
        'final_test_id' => \App\Models\FinalTest::factory(),
        'answer_text' => $this->faker->optional()->paragraph(),
        'answer_file' => $this->faker->optional()->filePath(),
        'score' => $this->faker->optional()->numberBetween(0, 100),
        ];
    }
}