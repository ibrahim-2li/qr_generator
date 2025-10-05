<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Moyasar\Providers\PaymentService;
use Exception;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function pay(Request $request)
    {
        $planId = $request->input('plan_id') ?? session('selected_plan_id');
        $user = Auth::user();

        if (!$planId || !$user) {
            return redirect()->route('filament.dashboard.pages.subscribe-page')
                ->with('error', 'Error in request data.');
        }

        $plan = \App\Models\Plan::findOrFail($planId);

        // Create subscription
        $subscription = \App\Models\Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'pending',
        ]);

        // Create Moyasar invoice for payment form
        $invoiceData = [
            'amount' => $plan->price, // Already in halalas
            'currency' => 'SAR',
            'description' => "Subscription to {$plan->name}",
            'callback_url' => route('payment.callback'),
            'metadata' => [
                'subscription_id' => $subscription->id,
                'user_id' => $user->id,
                'plan' => $plan->name
            ]
        ];

        try {
            $response = Http::withBasicAuth(config('services.moyasar.secret'), '')
                ->timeout(15)
                ->post('https://api.moyasar.com/v1/invoices', $invoiceData);

            if ($response->successful()) {
                $invoice = $response->json();

                // Store invoice ID in session for callback
                session(['moyasar_invoice_id' => $invoice['id']]);

                // Redirect to Moyasar payment form
                return redirect($invoice['url']);
            } else {
                return redirect()->route('filament.dashboard.pages.subscribe-page')
                    ->with('error', 'Failed to create payment process.');
            }
        } catch (Exception $e) {
            return redirect()->route('filament.dashboard.pages.subscribe-page')
                ->with('error', 'Error in connecting to payment service.');
        }
    }

    public function callback(Request $request)
    {
        $invoiceId = $request->query('id') ?? session('moyasar_invoice_id');

        if (! $invoiceId) {
            return redirect()->route('filament.dashboard.pages.subscribe-page')->with('error', 'Failed to determine payment process.');
        }

        // جلب تفاصيل الفاتورة من Moyasar API
        $response = Http::withBasicAuth(config('services.moyasar.secret'), '')
            ->get("https://api.moyasar.com/v1/invoices/{$invoiceId}");

        $invoice = $response->json();

        if (! isset($invoice['status'])) {
            return redirect()->route('filament.dashboard.pages.subscribe-page')->with('error', 'Failed to query payment status.');
        }

        // استرجاع الاشتراك من metadata
        $subscriptionId = $invoice['metadata']['subscription_id'] ?? null;

        if (! $subscriptionId) {
            return redirect()->route('filament.dashboard.pages.subscribe-page')->with('error', 'Subscription not found.');
        }

        $subscription = Subscription::find($subscriptionId);

        if (! $subscription) {
            return redirect()->route('filament.dashboard.pages.subscribe-page')->with('error', 'Subscription not found.');
        }

        // حفظ تفاصيل الدفع
        $subscription->payments()->create([
            'payment_id' => $invoice['id'],
            'amount' => $invoice['amount'],
            'status' => $invoice['status'],
            'payload' => $invoice,
        ]);

        if ($invoice['status'] === 'paid') {
            $subscription->update([
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => now()->addMonth(),
            ]);

            return redirect()->route('filament.dashboard.pages.my-subscription-page')->with('success', '✅ Payment successful and subscription activated.');
        }

        return redirect()->route('filament.dashboard.pages.subscribe-page')->with('error', '❌ Payment failed or cancelled.');
    }
}
