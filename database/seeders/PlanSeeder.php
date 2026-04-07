<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'name' => 'Pro',
            'description' => 'Get up and running with a free account. No card required.',
            'price' => '29900',
            'interval' => 360,
            'is_active' => true,
                'features' => [
                    ['text' => 'TLS/SSL encryption', 'check' => true],
                    ['text' => 'No time limit', 'check' => true],
                    ['text' => 'Access control', 'check' => true],
                    ['text' => 'Persistent URLs', 'check' => true],
                    ['text' => 'Custom domains and subdomains', 'check' => true],
                    ['text' => 'Reserved subdomains', 'check' => true],
                    ['text' => 'Global server network', 'check' => true],
                ],
        ]);
        Plan::create([
            'name' => 'Hobby',
            'description' => 'Get up and running with a free account. No card required.',
            'price' => 0,
            'interval' => 0,
            'is_active' => true,
            'features' => [
                ['text' => 'TLS/SSL encryption', 'check' => true],
                ['text' => 'Time limit', 'check' => false],
                ['text' => 'Random URLs', 'check' => false],
                ['text' => 'Single EU server', 'check' => false],
            ],
        ]);
        Plan::create([
            'name' => 'Team',
            'description' => 'Get up and running with a free account. No card required.',
            'price' => '90000',
            'interval' => 360,
            'is_active' => true,
            'features' => [
                ['text' => 'Everything in Pro', 'check' => true],
                ['text' => 'Priority support', 'check' => true],
                ['text' => 'Up to 10 users', 'check' => true],
            ],
        ]);
    }
}
