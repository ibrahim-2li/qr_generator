<?php

namespace App\Livewire\Dashboard\Billing;

use Livewire\Component;

class PaymentPage extends Component
{
    public $plan;

    public function mount($planId = null): void
    {
        if ($planId) {
            $this->plan = \App\Models\Plan::findOrFail($planId);
        }
    }

    public function render()
    {
        return view('livewire.dashboard.billing.payment-page')
            ->layout('layouts.dashboard', ['title' => __('dashboard.complete_payment')]);
    }
}
