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
        return [
           'qr_code_id' => QrCode::factory(),
           'ip' =>fake()->ipv4(),
           'country' => fake()->country(),
           'region' => fake()->city(),
           'city' => fake()->city(),
           'device' => fake()->randomElement(['mobile', 'desktop']),
           'os' => fake()->randomElement(['Windows', 'Mac OS', 'Linux', 'iOS', 'Android']),
           'created_at' => fake()->dateTime(),
           'updated_at' => fake()->dateTime(),
        ];
    }
}
