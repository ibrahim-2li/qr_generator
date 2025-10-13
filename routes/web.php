<?php

use App\Filament\Pages\PaymentPage;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentFormController;
use App\Http\Controllers\QrCodeController;
use App\Models\Faq;
use App\Models\Partner;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $faqs = Faq::all();
    $partners = Partner::all();

    return view('welcome', ['faqs' => $faqs, 'partners' => $partners]);
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('q/{qr}', [QrCodeController::class, 'sh'])->name('qr.sh');
Route::get('qr/{qr}/vcard', [QrCodeController::class, 'downloadVcard'])->name('qr.vcard');

// Moyasar payment
Route::get('/moyasar/pay', [PaymentController::class, 'pay'])->name('payment.pay');
Route::post('/moyasar/pay', [PaymentController::class, 'pay'])->name('payment.pay.post');

// Callback from Moyasar (server-side)
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');


// Redirect after payment (browser redirect)
Route::get('/payment/redirect', [PaymentController::class, 'redirect'])
    ->name('payment.redirect');


// Route::get('/payment/form', [PaymentFormController::class, 'show'])->name('payment.form');

// Route::get('/payment/{planId}', PaymentPage::class)->name('payment.page');
