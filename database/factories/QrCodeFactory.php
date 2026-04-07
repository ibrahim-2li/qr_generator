<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Scan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QrCode>
 */
class QrCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1, // User::factory(),
            'type' => 'vcard',
            'is_dynamic' => false,
            'slug' => Str::random(8),
            'scan_count' => random_int(0, 100),
            'created_at' => fake()->dateTime(),
            'updated_at' => fake()->dateTime(),
        ];
    }
}
