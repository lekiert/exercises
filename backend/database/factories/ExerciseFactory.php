<?php

namespace Database\Factories;

use App\Exercise\Model\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Exercise\Model\Exercise>
 */
class ExerciseFactory extends Factory
{
    protected $model = Exercise::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id' => 1,
            'type' => 'brackets',
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'definition' => [],
            'solution' => [],
        ];
    }
}
