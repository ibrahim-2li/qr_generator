<?php

namespace App\Livewire\Dashboard;

use App\Models\QrCode;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{
    public $qrCodesCount = 0;

    public $activeSubscription = null;

    public $trialStatus = null;

    public $recentQrCodes = [];

    public function mount(): void
    {
        $user = Auth::user();

        $this->qrCodesCount = QrCode::where('user_id', $user->id)->count();

        $this->activeSubscription = Subscription::with('plan')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->first();

        $this->trialStatus = $user->getTrialStatus();

        $this->recentQrCodes = QrCode::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.home')
            ->layout('layouts.dashboard', ['title' => __('dashboard.dashboard')]);
    }
}
