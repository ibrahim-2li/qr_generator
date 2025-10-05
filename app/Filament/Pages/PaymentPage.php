<?php

namespace App\Filament\Pages;

use App\Models\Plan;
use App\Models\Subscription;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class PaymentPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes;

    protected static ?string $title = 'إتمام الدفع';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.pages.payment-page';

    public $plan;

    public $subscription;

    public function mount($planId = null)
    {
        if ($planId) {
            $this->plan = Plan::findOrFail($planId);

            $this->subscription = Subscription::create([
                'user_id' => Auth::id(),
                'plan_id' => $this->plan->id,
                'status' => 'pending',
            ]);
        }
    }

    public function getPaymentCallbackUrlProperty()
    {
        return route('payment.callback');
    }
}
