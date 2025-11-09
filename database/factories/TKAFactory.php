<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TKA>
 */
class TKAFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\TKA::class;
    public function definition(): array
    {
        //
        $questions = [];
        for ($i = 0; $i < 5; $i++) {
            $qid = Str::uuid();
            $options = collect(range(1, 4))->map(fn($j) => [
                'id' => Str::uuid(),
                'text' => $this->faker->word(),
                'is_correct' => $j === 1, // opsi pertama benar
            ])->toArray();

            $questions[] = [
                'id' => $qid,
                'text' => $this->faker->sentence(6),
                'options' => $options,
            ];
        }
        return [
            'title' => 'TKA ' . $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'questions' => $questions,
        ];
    }
}