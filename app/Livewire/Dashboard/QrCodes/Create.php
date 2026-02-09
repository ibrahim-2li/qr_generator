<?php

namespace App\Livewire\Dashboard\QrCodes;

use App\Models\QrCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    // QR Code fields
    public string $type = 'vcard';

    public bool $is_dynamic = true;

    // vCard fields
    public string $content_name = '';

    public string $content_title = '';

    public string $content_phone = '';

    public string $content_email = '';

    public string $content_company = '';

    public string $content_linkedin = '';

    public string $content_x = '';

    public string $content_snap = '';

    public string $content_facebook = '';

    public string $content_instagram = '';

    public string $content_youtube = '';

    public string $content_color_l = '#232421';

    public string $content_color_d = '#f78e31';

    public $content_profile_photo = null;

    // PDF fields
    public string $pdf_name = '';

    public string $pdf_description = '';

    public string $pdf_color_l = '#f78e31';

    public string $pdf_color_d = '#527ac9';

    public $pdf_file = null;

    protected function rules(): array
    {
        $rules = [
            'type' => 'required|in:vcard,pdf',
            'is_dynamic' => 'required|boolean',
        ];

        if ($this->type === 'vcard') {
            $rules = array_merge($rules, [
                'content_name' => 'required|string|max:255',
                'content_title' => 'nullable|string|max:255',
                'content_phone' => 'required|string|max:50',
                'content_email' => 'required|email|max:255',
                'content_company' => 'nullable|string|max:255',
                'content_linkedin' => 'nullable|url|max:255',
                'content_x' => 'nullable|url|max:255',
                'content_snap' => 'nullable|string|max:255',
                'content_facebook' => 'nullable|url|max:255',
                'content_instagram' => 'nullable|url|max:255',
                'content_youtube' => 'nullable|url|max:255',
                'content_color_l' => 'required|string',
                'content_color_d' => 'required|string',
                'content_profile_photo' => 'nullable|image|max:2048',
            ]);
        }

        if ($this->type === 'pdf') {
            $rules = array_merge($rules, [
                'pdf_name' => 'required|string|max:255',
                'pdf_description' => 'required|string',
                'pdf_color_l' => 'required|string',
                'pdf_color_d' => 'required|string',
                'pdf_file' => 'required|file|mimes:pdf|max:8048',
            ]);
        }

        return $rules;
    }

    public function mount(): void
    {
        $user = Auth::user();

        // Check if user can create QR codes
        if (! $user->canCreateQrCodes()) {
            session()->flash('warning', 'You need an active subscription or trial to create QR codes.');
            $this->redirect(route('dashboard.billing'));
        }
    }

    public function updatedType(): void
    {
        // Reset validation when type changes
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $this->validate();

        $user = Auth::user();

        // Double-check permission
        if (! $user->canCreateQrCodes()) {
            session()->flash('error', 'You need an active subscription to create QR codes.');
            $this->redirect(route('dashboard.billing'));

            return;
        }

        // Create the QR code
        $qrCode = QrCode::create([
            'user_id' => $user->id,
            'type' => $this->type,
            'is_dynamic' => $this->is_dynamic,
            'slug' => Str::random(8),
            'scan_count' => 0,
        ]);

        if ($this->type === 'vcard') {
            // Handle profile photo upload
            $profilePhotoPath = null;
            if ($this->content_profile_photo) {
                $profilePhotoPath = $this->content_profile_photo->store('profile-photos', 'public');
            }

            // Create content
            $qrCode->content()->create([
                'name' => $this->content_name,
                'title' => $this->content_title,
                'phone' => $this->content_phone,
                'email' => $this->content_email,
                'company' => $this->content_company,
                'linkedin' => $this->content_linkedin,
                'x' => $this->content_x,
                'snap' => $this->content_snap,
                'facebook' => $this->content_facebook,
                'instagram' => $this->content_instagram,
                'youtube' => $this->content_youtube,
                'color_l' => $this->content_color_l,
                'color_d' => $this->content_color_d,
                'profile_photo_path' => $profilePhotoPath,
            ]);
        }

        if ($this->type === 'pdf') {
            // Handle PDF file upload
            $pdfPath = $this->pdf_file->store('files', 'public');

            // Create PDF record
            $qrCode->pdf()->create([
                'name' => $this->pdf_name,
                'description' => $this->pdf_description,
                'color_l' => $this->pdf_color_l,
                'color_d' => $this->pdf_color_d,
                'file' => $pdfPath,
            ]);
        }

        session()->flash('success', 'QR Code created successfully!');
        $this->redirect(route('dashboard.qrcodes.view', $qrCode->id));
    }

    public function render()
    {
        return view('livewire.dashboard.qr-codes.create', [
            'types' => QrCode::TYPE,
        ])->layout('layouts.dashboard', ['title' => 'Create QR Code']);
    }
}
