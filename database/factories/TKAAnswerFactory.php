<?php

namespace Database\Factories;

use App\Models\TKA;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TKAAnswer>
 */
class TKAAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\TKAAnswer::class;
    public function definition(): array
    {
            $test = TKA::inRandomOrder()->first() ?? TKA::factory()->create();
            $user = User::inRandomOrder()->first() ?? User::factory()->create();

            $answer = collect($test->questions)->map(function ($q) {
            $randomOpt = Arr::random($q['options']);
            return [
                'question_id' => $q['id'],
                'selected_option_id' => $randomOpt['id'],
            ];
        })->toArray();

        $score = rand(50, 100);
        return [
            't_k_a_id' => $test->id,
            'user_id' => $user->id,
            'answers' => $answer,
            'score' => $score,
            'submitted_at' => now(),
        ];
    }
}