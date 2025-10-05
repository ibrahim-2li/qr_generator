<?php

namespace App\Http\Controllers;

class PaymentFormController extends Controller
{
    public function show()
    {
        $paymentData = session('payment_data');

        if (! $paymentData) {
            return redirect()->route('filament.dashboard.pages.subscribe-page')
                ->with('error', 'لم يتم العثور على بيانات الدفع.');
        }

        return view('payment.form', compact('paymentData'));
    }
}
