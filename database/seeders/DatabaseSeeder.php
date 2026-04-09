<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\FaqSeeder;
use Database\Seeders\PartnerSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        $this->call([
            PlanSeeder::class,
            PartnerSeeder::class,
            FaqSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Ibrahim Alhag',
            'email' => 'ibrahim.2li@hotmail.com',
            'password' => Hash::make('P@$$w0rd'),
            'role' => User::ROLE_SUPER_ADMIN,
            'email_verified_at' => now(),
        ]);
    }
}
