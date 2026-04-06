<?php

namespace App\Livewire\Dashboard\QrCodes;

use App\Models\QrCode;
use chillerlan\QRCode\QRCode as QRCodeGenerator;
use chillerlan\QRCode\QROptions;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;

class View extends Component
{
    #[Locked]
    public int $qrCodeId;

    public ?QrCode $qrCode = null;

    public ?string $qrCodeImage = null;

    public function mount(QrCode $qrCode): void
    {
        $this->qrCodeId = $qrCode->id;
        $this->qrCode = $qrCode->load(['user', 'content', 'pdf', 'scans']);

        // Check permission
        $user = Auth::user();
        if ($user->isUser() && $this->qrCode->user_id !== $user->id) {
            abort(403, 'You do not have permission to view this QR code.');
        }

        // Generate QR code image
        $this->generateQrCodeImage();
    }

    protected function generateQrCodeImage(): void
    {
        if (! $this->qrCode->slug) {
            return;
        }

        $options = new QROptions([
            'outputType' => QRCodeGenerator::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCodeGenerator::ECC_L,
            'scale' => 10,
            'imageBase64' => true,
        ]);

        $generator = new QRCodeGenerator($options);
        $url = url('/q/'.$this->qrCode->slug);
        $this->qrCodeImage = $generator->render($url);
    }

    public function deleteQrCode(): void
    {
        $user = Auth::user();

        if ($user->isUser() && $this->qrCode->user_id !== $user->id) {
            session()->flash('error', 'You do not have permission to delete this QR code.');

            return;
        }

        $this->qrCode->delete();
        session()->flash('success', 'QR Code deleted successfully.');
        $this->redirect(route('dashboard.qrcodes'));
    }

    public function render()
    {
        return view('livewire.dashboard.qr-codes.view')
            ->layout('layouts.dashboard', ['title' => 'View QR Code']);
    }
}
