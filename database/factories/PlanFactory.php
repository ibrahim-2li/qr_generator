<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Basic', 'Pro', 'Enterprise']),
            'description' => fake()->sentence(),
            'price' => fake()->randomNumber(4) * 100, // Price in halalas
            'interval' => fake()->randomElement([30, 90, 365]),
        ];
    }

    /**
     * Create a monthly plan.
     */
    public function monthly(): static
    {
        return $this->state(fn (array $attributes) => [
            'interval' => 30,
        ]);
    }

    /**
     * Create a yearly plan.
     */
    public function yearly(): static
    {
        return $this->state(fn (array $attributes) => [
            'interval' => 365,
        ]);
    }
}
