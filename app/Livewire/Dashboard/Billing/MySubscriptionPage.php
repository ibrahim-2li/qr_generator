<?php

namespace App\Livewire\Dashboard\Billing;

use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class MySubscriptionPage extends Component
{
    use WithPagination;

    public $subscription;

    public function mount(): void
    {
        $this->subscription = Subscription::with('plan', 'payments')
            ->where('user_id', Auth::id())
            ->latest()
            ->first();
    }

    public function getPaymentsProperty()
    {
        if (! $this->subscription) {
            return collect();
        }

        return $this->subscription->payments()->latest()->get();
    }

    public function renew(): void
    {
        if (! $this->subscription) {
            $this->dispatch('subscription-updated', [
                'status' => 'no_subscription',
            ]);

            return;
        }

        $plan = $this->subscription->plan;

        $response = Http::withBasicAuth(config('services.moyasar.secret'), '')
            ->post('https://api.moyasar.com/v1/payments', [
                'amount' => $plan->price,
                'currency' => 'SAR',
                'description' => "تجديد اشتراك {$plan->name}",
                'callback_url' => route('payment.callback'),
                'source' => [
                    'type' => 'creditcard',
                    'name' => 'عميل ميسر',
                    'number' => '4111111111111111',
                    'cvc' => '123',
                    'month' => '12',
                    'year' => '30',
                ],
            ]);

        $data = $response->json();

        $this->subscription->payments()->create([
            'payment_id' => $data['id'] ?? null,
            'amount' => $plan->price,
            'status' => $data['status'] ?? 'failed',
            'payload' => $data,
        ]);

        if (($data['status'] ?? '') === 'paid') {
            $this->subscription->update([
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => now()->addMonth(),
            ]);
        }

        $this->dispatch('subscription-updated', [
            'status' => $this->subscription->status,
        ]);
    }

    public function cancel(): void
    {
        if ($this->subscription) {
            $this->subscription->update(['status' => 'canceled']);
            $this->dispatch('subscription-canceled');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.billing.my-subscription-page')
            ->layout('layouts.dashboard', ['title' => __('dashboard.subscription')]);
    }
}
