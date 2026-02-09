<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QrCodeController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard\Billing\MySubscriptionPage;
use App\Livewire\Dashboard\Billing\PaymentPage;
use App\Livewire\Dashboard\Billing\SubscribePage;
use App\Livewire\Dashboard\Home;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\Plan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $faqs = Faq::all();
    $partners = Partner::all();
    $plans = Plan::all();

    return view('welcome', ['faqs' => $faqs, 'partners' => $partners, 'plans' => $plans]);
})->name('landing');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Livewire)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
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

/*
|--------------------------------------------------------------------------
| New Livewire Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('app')->group(function () {
    // Dashboard Home
    Route::get('/', Home::class)->name('dashboard.home');

    // Subscription Management
    Route::get('/subscription', MySubscriptionPage::class)->name('dashboard.subscription');

    // Billing / Subscribe
    Route::get('/billing', SubscribePage::class)->name('dashboard.billing');
    Route::get('/payment/{planId?}', PaymentPage::class)->name('dashboard.payment');

    // Profile
    Route::get('/profile', \App\Livewire\Dashboard\Profile::class)->name('dashboard.profile');

    // Analytics
    Route::get('/analytics', \App\Livewire\Dashboard\Analytics::class)->name('dashboard.analytics');

    // QR Codes
    Route::get('/qrcodes', \App\Livewire\Dashboard\QrCodes\Index::class)->name('dashboard.qrcodes');
    Route::get('/qrcodes/create', \App\Livewire\Dashboard\QrCodes\Create::class)->name('dashboard.qrcodes.create');
    Route::get('/qrcodes/{qrCode}', \App\Livewire\Dashboard\QrCodes\View::class)->name('dashboard.qrcodes.view');
    Route::get('/qrcodes/{qrCode}/edit', \App\Livewire\Dashboard\QrCodes\Edit::class)->name('dashboard.qrcodes.edit');

    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::get('/users', \App\Livewire\Dashboard\Admin\Users::class)->name('dashboard.admin.users');
        Route::get('/plans', \App\Livewire\Dashboard\Admin\Plans::class)->name('dashboard.admin.plans');
        Route::get('/subscriptions', \App\Livewire\Dashboard\Admin\Subscriptions::class)->name('dashboard.admin.subscriptions');
        Route::get('/payments', \App\Livewire\Dashboard\Admin\Payments::class)->name('dashboard.admin.payments');
        Route::get('/partners', \App\Livewire\Dashboard\Admin\Partners::class)->name('dashboard.admin.partners');
        Route::get('/messages', \App\Livewire\Dashboard\Admin\Messages::class)->name('dashboard.admin.messages');
        Route::get('/faqs', \App\Livewire\Dashboard\Admin\Faqs::class)->name('dashboard.admin.faqs');
    });
});

/*
|--------------------------------------------------------------------------
| Backward Compatibility Aliases (temporary until migration complete)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard/subscribe-page', function () {
    return redirect()->route('dashboard.billing');
})->name('filament.dashboard.pages.subscribe-page');

Route::get('/dashboard/my-subscription-page', function () {
    return redirect()->route('dashboard.subscription');
})->name('filament.dashboard.pages.my-subscription-page');

// Logout route
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');
