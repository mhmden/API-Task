<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'content' => $this->faker->text($maxNbChars = 200),
            'status_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'parent_id' => $this->faker->numberBetween($min = 1, $max = 5),
        ];
    }
}
