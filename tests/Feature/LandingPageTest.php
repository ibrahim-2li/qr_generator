<?php

use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the redesigned landing page', function () {
    Plan::query()->create([
        'name' => 'Pro',
        'description' => 'Built for growing teams.',
        'price' => 29900,
        'interval' => 30,
        'is_active' => true,
        'features' => [
            ['text' => 'Dynamic QR codes', 'check' => true],
        ],
    ]);

    $response = $this->get('/');

    $response
        ->assertSuccessful()
        ->assertSee('Expo-inspired redesign')
        ->assertSee('with a sharper landing page')
        ->assertSee('Flexible for solo makers')
        ->assertSee('Dynamic QR codes');
});
