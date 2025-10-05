<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
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
        $user = auth()->user();

        if (!$planId || !$user) {
            return redirect()->route('filament.dashboard.pages.subscribe-page')
                ->with('error', 'خطأ في بيانات الطلب.');
        }

        $plan = \App\Models\Plan::findOrFail($planId);

        // Create subscription
        $subscription = \App\Models\Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'pending',
        ]);

        // Create Moyasar payment with minimal source for redirect
        $paymentData = [
            'amount' => $plan->price, // Already in halalas
            'currency' => 'SAR',
            'description' => "اشتراك في {$plan->name}",
            'callback_url' => route('payment.callback'),
            'source' => [
                'type' => 'creditcard',
                'name' => $user->name,
                'number' => '4111111111111111',
                'month' => '12',
                'year' => '2025',
                'cvc' => '123'
            ],
            'metadata' => [
                'subscription_id' => $subscription->id,
                'user_id' => $user->id,
                'plan' => $plan->name
            ]
        ];

        try {
            $response = Http::withBasicAuth(config('services.moyasar.secret'), '')
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
                return redirect()->route('filament.dashboard.pages.subscribe-page')
                    ->with('error', 'فشل في إنشاء عملية الدفع.');
            }
        } catch (Exception $e) {
            return redirect()->route('filament.dashboard.pages.subscribe-page')
                ->with('error', 'خطأ في الاتصال بخدمة الدفع.');
        }
    }

    public function callback(Request $request)
    {
        $paymentId = $request->query('id');

        if (! $paymentId) {
            return redirect()->route('filament.dashboard.pages.subscribe-page')->with('error', 'تعذر تحديد عملية الدفع.');
        }

        // جلب تفاصيل الدفع من Moyasar API
        $response = Http::withBasicAuth(config('services.moyasar.secret'), '')
            ->get("https://api.moyasar.com/v1/payments/{$paymentId}");

        $data = $response->json();

        if (! isset($data['status'])) {
            return redirect()->route('filament.dashboard.pages.subscribe-page')->with('error', 'تعذر استعلام حالة الدفع.');
        }

        // استرجاع الاشتراك من metadata
        $subscriptionId = $data['metadata']['subscription_id'] ?? null;

        if (! $subscriptionId) {
            return redirect()->route('filament.dashboard.pages.subscribe-page')->with('error', 'لم يتم العثور على الاشتراك.');
        }

        $subscription = Subscription::find($subscriptionId);

        if (! $subscription) {
            return redirect()->route('filament.dashboard.pages.subscribe-page')->with('error', 'الاشتراك غير موجود.');
        }

        // حفظ تفاصيل الدفع
        $subscription->payments()->create([
            'payment_id' => $data['id'],
            'amount' => $data['amount'],
            'status' => $data['status'],
            'payload' => $data,
        ]);

        if ($data['status'] === 'paid') {
            $subscription->update([
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => now()->addMonth(),
            ]);

            return redirect()->route('filament.dashboard.pages.my-subscription-page')->with('success', '✅ تم الدفع وتفعيل الاشتراك بنجاح.');
        }

        return redirect()->route('filament.dashboard.pages.subscribe-page')->with('error', '❌ فشل الدفع أو تم إلغاؤه.');
    }
}
