<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalogue>
 */
class CatalogueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'tags' => 'AI, machine learning, python',
            'author' => fake()->title(),
            'category' => fake()->title(),
            'description' => fake()->paragraph(),
            'total_copies' => 20,
            'available_copies' => 10,
            'published_year' => fake()->year(),
        ];
    }
}
