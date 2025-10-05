<?php

namespace App\Filament\Pages;

use App\Models\Plan;
use App\Models\Subscription;
use BackedEnum;
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

    // Card form fields
    public $cardNumber = '';
    public $cardName = '';
    public $expiryMonth = '';
    public $expiryYear = '';
    public $cvc = '';

    protected $rules = [
        'cardNumber' => 'required|string|size:16',
        'cardName' => 'required|string|max:255',
        'expiryMonth' => 'required|string|size:2',
        'expiryYear' => 'required|string|size:2',
        'cvc' => 'required|string|min:3|max:4',
    ];

    public function mount()
    {
        $this->plans = Plan::all();
        $this->cardName = Auth::user()->name ?? '';
    }

    public function selectPlan($planId)
    {
        $this->selectedPlan = Plan::findOrFail($planId);
        $this->showPaymentForm = true;
    }

    public function backToPlans()
    {
        $this->selectedPlan = null;
        $this->showPaymentForm = false;
        $this->reset(['cardNumber', 'expiryMonth', 'expiryYear', 'cvc']);
    }

    public function processPayment()
    {
        $this->validate();

        $user = Auth::user();
        $plan = $this->selectedPlan;

        // Create subscription
        $subscription = \App\Models\Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'pending',
        ]);

        // Create Moyasar payment with user's card data
        $paymentData = [
            'amount' => $plan->price, // Already in halalas
            'currency' => 'SAR',
            'description' => "Subscription to {$plan->name}",
            'callback_url' => route('payment.callback'),
            'source' => [
                'type' => 'creditcard',
                'name' => $this->cardName,
                'number' => $this->cardNumber,
                'month' => $this->expiryMonth,
                'year' => '20' . $this->expiryYear,
                'cvc' => $this->cvc
            ],
            'metadata' => [
                'subscription_id' => $subscription->id,
                'user_id' => $user->id,
                'plan' => $plan->name
            ]
        ];

        try {
            $response = \Illuminate\Support\Facades\Http::withBasicAuth(config('services.moyasar.secret'), '')
                ->timeout(15)
                ->post('https://api.moyasar.com/v1/payments', $paymentData);

            if ($response->successful()) {
                $payment = $response->json();

                // Store payment ID in session for callback
                session(['moyasar_payment_id' => $payment['id']]);

                // Check if payment has transaction_url for redirect
                if (isset($payment['source']['transaction_url'])) {
                    return redirect($payment['source']['transaction_url']);
                } else {
                    // Fallback to moyasar.com/pay URL
                    return redirect("https://moyasar.com/pay/{$payment['id']}");
                }
            } else {
                $this->addError('payment', 'فشل في إنشاء عملية الدفع.');
            }
        } catch (Exception $e) {
            $this->addError('payment', 'خطأ في الاتصال بخدمة الدفع.');
        }
    }

}
