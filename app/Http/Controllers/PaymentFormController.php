<?php

namespace App\Http\Controllers;

class PaymentFormController extends Controller
{
    public function show()
    {
        $paymentData = session('payment_data');

        if (! $paymentData) {
            return redirect()->route('dashboard.billing')
                ->with('error', 'لم يتم العثور على بيانات الدفع.');
        }

        return view('payment.form', compact('paymentData'));
    }
}
