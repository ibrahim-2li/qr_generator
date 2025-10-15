<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
                'name' => 'Gold Plan',
                'description' => 'Gold Plan',
                'price' => '100000',
                'interval' => 'year',
            ]);
            Plan::create([
                'name' => 'Silver Plan',
                'description' => 'Silver Plan',
                'price' => '50000',
                'interval' => 'year',
            ]);
    }
}
