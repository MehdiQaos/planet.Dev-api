<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $numWords = rand(5, 100);
        return [
            'content' => fake()->realTextBetween(50, 300),
            // 'content' => fake()->sentenc($numWords),

        ];
    }
}
