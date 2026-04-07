<?php

namespace Database\Factories;

use App\Models\QrCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Scan>
 */
class ScanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // recycle QrCode::factory();

        return [
            'qr_code_id' => QrCode::factory(),
            'ip' => fake()->ipv4(),
            'country' => fake()->country(),
            'region' => fake()->city(),
            'city' => fake()->city(),
            'device' => fake()->randomElement(['mobile', 'desktop']),
            'os' => fake()->randomElement(['Windows', 'Mac OS', 'Linux', 'iOS', 'Android']),
            'created_at' => fake()->dateTimeBetween('first day of last month', 'last day of last month')->format('Y-m-d H:i:s'),
            'updated_at' => fake()->dateTimeBetween('first day of last month', 'last day of last month')->format('Y-m-d H:i:s'),
        ];
    }
}
