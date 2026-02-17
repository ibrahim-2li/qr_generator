<?php

namespace App\Livewire\Dashboard;

use App\Models\QrCode;
use chillerlan\QRCode\QROptions;
use App\Models\Subscription;
use chillerlan\QRCode\QRCode as QRCodeGenerator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{
    public $qrCodesCount = 0;

    public $activeSubscription = null;

    public $trialStatus = null;

    public $recentQrCodes = [];

    public function generateQrCodeImage(QrCode $qrCode): ?string
    {
        if (! $qrCode->slug) {
            return null;
        }

        $options = new QROptions([
            'outputType' => QRCodeGenerator::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCodeGenerator::ECC_L,
            'scale' => 5,
            'imageBase64' => true,
        ]);

        $generator = new QRCodeGenerator($options);
        $url = url('/q/'.$qrCode->slug);

        return $generator->render($url);
    }

     public function getQrCodeStatus(QrCode $qrCode): string
    {
        $user = $qrCode->user;

        if (! $user) {
            return 'inactive';
        }

        // Admin users are always active
        if ($user->role === \App\Models\User::ROLE_ADMIN || $user->role === \App\Models\User::ROLE_SUPER_ADMIN) {
            return 'active';
        }

        // Check active subscription
        if ($user->subscriptions()->where('status', 'active')->where('ends_at', '>', now())->exists()) {
            return 'active';
        }

        // Check trial
        if ($user->trial_ends_at && $user->trial_ends_at > now()) {
            return 'active';
        }

        return 'inactive';
    }

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
