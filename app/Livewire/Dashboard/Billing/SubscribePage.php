<?php

namespace App\Livewire\Dashboard\Billing;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SubscribePage extends Component
{
    public $plans;

    public $selectedPlan = null;

    public bool $showPaymentForm = false;

    public $currentSubscription = null;

    public $trialStatus = null;

    public function mount(): void
    {
        $this->plans = Plan::all();

        // Get current active subscription
        $this->currentSubscription = Subscription::with('plan')
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->latest()
            ->first();

        // Get trial status
        $this->trialStatus = Auth::user()->getTrialStatus();
    }

    public function selectPlan($planId): void
    {
        $this->selectedPlan = Plan::findOrFail($planId);
        $this->showPaymentForm = true;
        $this->dispatch('plan-selected');
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

    public function render()
    {
        return view('livewire.dashboard.billing.subscribe-page')
            ->layout('layouts.dashboard', ['title' => __('dashboard.billing')]);
    }
}
