<?php

use App\Filament\Pages\PaymentPage;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentFormController;
use App\Http\Controllers\QrCodeController;
use App\Models\Faq;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $faqs = Faq::all();

    return view('welcome', ['faqs' => $faqs]);
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('q/{qr}', [QrCodeController::class, 'sh'])->name('qr.sh');
Route::get('qr/{qr}/vcard', [QrCodeController::class, 'downloadVcard'])->name('qr.vcard');

Route::post('/moyasar/pay', [PaymentController::class, 'pay'])->name('payment.pay');
Route::post('/payment/pay', [PaymentController::class, 'pay'])->name('payment.pay.direct');
Route::get('/moyasar/callback', [PaymentController::class, 'callback'])->name('payment.callback');

// Payment form route
Route::get('/payment/form', [PaymentFormController::class, 'show'])->name('payment.form');

Route::get('/payment/{planId}', PaymentPage::class)->name('payment.page');

// Callback من Moyasar بعد الدفع
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
