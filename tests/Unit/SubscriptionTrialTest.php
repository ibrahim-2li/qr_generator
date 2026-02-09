<?php

namespace Tests\Unit;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTrialTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_start_trial(): void
    {
        $user = User::factory()->create([
            'trial_ends_at' => null,
            'trial_used' => false,
        ]);

        $user->startTrial();

        $this->assertTrue($user->fresh()->trial_used);
        $this->assertNotNull($user->fresh()->trial_ends_at);
        $this->assertTrue($user->fresh()->trial_ends_at->isFuture());
    }

    public function test_user_cannot_start_trial_twice(): void
    {
        $user = User::factory()->create([
            'trial_ends_at' => now()->addDays(7),
            'trial_used' => true,
        ]);

        $originalTrialEnd = $user->trial_ends_at->toDateTimeString();
        $user->startTrial();

        $this->assertEquals($originalTrialEnd, $user->fresh()->trial_ends_at->toDateTimeString());
    }

    public function test_user_on_active_trial_can_create_qr_codes(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_USER,
            'trial_ends_at' => now()->addDays(5),
            'trial_used' => true,
        ]);

        $this->assertTrue($user->canCreateQrCodes());
        $this->assertTrue($user->isOnTrial());
    }

    public function test_user_with_expired_trial_cannot_create_qr_codes(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_USER,
            'trial_ends_at' => now()->subDays(1),
            'trial_used' => true,
        ]);

        $this->assertFalse($user->canCreateQrCodes());
        $this->assertFalse($user->isOnTrial());
    }

    public function test_user_with_active_subscription_can_create_qr_codes(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_USER,
            'trial_ends_at' => null,
            'trial_used' => true,
        ]);

        Subscription::factory()->create([
            'user_id' => $user->id,
            'status' => 'active',
            'ends_at' => now()->addMonth(),
        ]);

        $this->assertTrue($user->canCreateQrCodes());
        $this->assertTrue($user->hasActiveSubscription());
    }

    public function test_admin_can_always_create_qr_codes(): void
    {
        $admin = User::factory()->admin()->create();

        $this->assertTrue($admin->canCreateQrCodes());
    }

    public function test_super_admin_can_always_create_qr_codes(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        $this->assertTrue($superAdmin->canCreateQrCodes());
    }

    public function test_trial_status_returns_correct_info(): void
    {
        $user = User::factory()->create([
            'trial_ends_at' => now()->addDays(3),
            'trial_used' => true,
        ]);

        $status = $user->getTrialStatus();

        $this->assertTrue($status['is_trial']);
        $this->assertGreaterThanOrEqual(2, $status['days_remaining']);
        $this->assertFalse($status['expired']);
    }

    public function test_expired_trial_status_returns_correct_info(): void
    {
        $user = User::factory()->create([
            'trial_ends_at' => now()->subDays(2),
            'trial_used' => true,
        ]);

        $status = $user->getTrialStatus();

        $this->assertFalse($status['is_trial']);
        $this->assertEquals(0, $status['days_remaining']);
        $this->assertTrue($status['expired']);
    }
}
