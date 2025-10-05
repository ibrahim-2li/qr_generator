<?php

namespace App\Filament\Pages;

use App\Models\Plan;
use App\Models\Subscription;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Exception;

class SubscribePage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::CreditCard;

    protected static ?string $title = 'Billing';

    protected string $view = 'filament.pages.subscribe-page';

    protected static ?int $navigationSort = 5;

    public $plans;
    public $selectedPlan = null;
    public $showPaymentForm = false;
    public $currentSubscription = null;

    public function mount(): void
    {
        $this->plans = Plan::all();

        // Get current active subscription
        $this->currentSubscription = Subscription::with('plan')
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->latest()
            ->first();
    }

    public function selectPlan($planId): void
    {
        $this->selectedPlan = Plan::findOrFail($planId);
        $this->showPaymentForm = true;
        $this->dispatch('plan-selected'); // Optional: dispatch event for debugging
    }

    public function backToPlans(): void
    {
        $this->selectedPlan = null;
        $this->showPaymentForm = false;
    }

    public function processPayment()
    {
        // Store selected plan in session and redirect to PaymentController
        session(['selected_plan_id' => $this->selectedPlan->id]);

        return redirect()->route('payment.pay');
    }

    public function isCurrentPlan($planId): bool
    {
        return $this->currentSubscription && $this->currentSubscription->plan_id == $planId;
    }
}
