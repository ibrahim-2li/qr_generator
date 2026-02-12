<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Moyasar\Providers\PaymentService;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Create a Moyasar invoice and redirect user to payment page.
     */
    public function pay(Request $request)
    {
        $planId = $request->input('plan_id') ?? session('selected_plan_id');
        $user = Auth::user();

        if (! $planId || ! $user) {
            return redirect()->route('dashboard.billing')
                ->with('error', 'Error in request data.');
        }

        $plan = \App\Models\Plan::findOrFail($planId);

        // Create a pending subscription before payment
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'pending',
        ]);

        // Create invoice payload
        $invoiceData = [
            'amount' => $plan->price, // in halalas
            'currency' => 'SAR',
            'description' => "Subscription to {$plan->name}",
            'callback_url' => route('payment.callback'),
            'success_url' => route('payment.success'), // ✅ correct for invoices
            'metadata' => [
                'subscription_id' => $subscription->id,
                'user_id' => $user->id,
                'plan' => $plan->name,
            ],
        ];

        try {
            $response = Http::withBasicAuth(config('services.moyasar.secret'), '')
                ->timeout(15)
                ->post('https://api.moyasar.com/v1/invoices', $invoiceData);

            if ($response->successful()) {
                $invoice = $response->json();

                session(['moyasar_invoice_id' => $invoice['id']]);

                // Redirect user to Moyasar’s hosted payment page
                return redirect($invoice['url']);
            }

            return redirect()->route('dashboard.billing')
                ->with('error', 'Failed to create payment process.');
        } catch (Exception $e) {
            return redirect()->route('dashboard.billing')
                ->with('error', 'Error connecting to payment service.');
        }
    }

    /**
     * Server-side callback from Moyasar after payment completion.
     */
    public function callback(Request $request)
    {
        $invoiceId = $request->query('id') ?? session('moyasar_invoice_id');

        if (! $invoiceId) {
            return response()->json(['error' => 'Missing invoice ID.'], 400);
        }

        $response = Http::withBasicAuth(config('services.moyasar.secret'), '')
            ->get("https://api.moyasar.com/v1/invoices/{$invoiceId}");

        if (! $response->successful()) {
            return response()->json(['error' => 'Failed to fetch invoice.'], 400);
        }

        $invoice = $response->json();
        $subscriptionId = $invoice['metadata']['subscription_id'] ?? null;

        if (! $subscriptionId) {
            return response()->json(['error' => 'Subscription ID not found.'], 400);
        }

        $subscription = Subscription::find($subscriptionId);

        if (! $subscription) {
            return response()->json(['error' => 'Subscription not found.'], 404);
        }

        // Record payment
        $subscription->payments()->create([
            'payment_id' => $invoice['id'],
            'amount' => $invoice['amount'],
            'status' => $invoice['status'],
            'payload' => $invoice,
        ]);

        // Activate subscription if paid
        if ($invoice['status'] === 'paid') {
            $subscription->update([
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => now()->addDays($subscription->plan->interval),
            ]);
        }

        // Respond to Moyasar (important)
        return response()->json(['status' => 'ok']);
    }

    /**
     * Browser redirect after payment (for the user).
     */
    public function redirect(Request $request)
    {
        $invoiceId = $request->query('id');

        if (! $invoiceId) {
            return redirect()->route('dashboard.billing')
                ->with('error', 'Missing invoice ID.');
        }

        // Fetch invoice info from Moyasar
        $response = Http::withBasicAuth(config('services.moyasar.secret'), '')
            ->get("https://api.moyasar.com/v1/invoices/{$invoiceId}");

        if (! $response->successful()) {
            return redirect()->route('dashboard.billing')
                ->with('error', 'Unable to verify payment.');
        }

        $invoice = $response->json();

        // Ensure metadata exists
        $subscriptionId = $invoice['metadata']['subscription_id'] ?? null;

        if (! $subscriptionId) {
            return redirect()->route('dashboard.billing')
                ->with('error', 'Subscription not found in payment data.');
        }

        $subscription = \App\Models\Subscription::find($subscriptionId);

        if (! $subscription) {
            return redirect()->route('dashboard.billing')
                ->with('error', 'Subscription record missing.');
        }

        // Record payment
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
                'ends_at' => now()->addDays($subscription->plan->interval),
            ]);

            return redirect()->route('dashboard.subscription')
                ->with('success', '✅ Payment successful and subscription activated.');
        }

        return redirect()->route('dashboard.billing')
            ->with('error', '❌ Payment failed or cancelled.');
    }

    public function success(Request $request)
    {
        $invoiceId = $request->query('invoice_id');

        if (! $invoiceId) {
            return response()->json(['error' => 'Missing invoice_id in redirect.'], 400);
        }

        try {
            $response = Http::withBasicAuth(config('services.moyasar.secret'), '')
                ->get("https://api.moyasar.com/v1/invoices/{$invoiceId}");

            if (! $response->successful()) {
                return response()->json(['error' => 'Failed to fetch invoice.'], 400);
            }

            $invoice = $response->json();

            $subscriptionId = $invoice['metadata']['subscription_id'] ?? null;
            if (! $subscriptionId) {
                return redirect()->route('dashboard.billing')
                    ->with('error', 'Subscription ID not found in metadata.');
            }

            $subscription = \App\Models\Subscription::find($subscriptionId);
            if (! $subscription) {
                return redirect()->route('dashboard.billing')
                    ->with('error', 'Subscription not found.');
            }

            // Save payment details
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
                    'ends_at' => now()->addDays($subscription->plan->interval),
                ]);

                return redirect()->route('dashboard.subscription')
                    ->with('success', '✅ Payment successful and subscription activated.');
            }

            return redirect()->route('dashboard.billing')
                ->with('error', '❌ Payment failed or was not completed.');

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
