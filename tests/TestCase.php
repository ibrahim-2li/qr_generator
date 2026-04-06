<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Create an authenticated user with the specified role.
     */
    protected function actingAsUser(string $role = User::ROLE_USER): User
    {
        $user = User::factory()->create(['role' => $role]);
        $this->actingAs($user);

        return $user;
    }

    /**
     * Create and authenticate as a regular user.
     */
    protected function actingAsRegularUser(): User
    {
        return $this->actingAsUser(User::ROLE_USER);
    }

    /**
     * Create and authenticate as an admin user.
     */
    protected function actingAsAdmin(): User
    {
        return $this->actingAsUser(User::ROLE_ADMIN);
    }

    /**
     * Create and authenticate as a super admin user.
     */
    protected function actingAsSuperAdmin(): User
    {
        return $this->actingAsUser(User::ROLE_SUPER_ADMIN);
    }
}
