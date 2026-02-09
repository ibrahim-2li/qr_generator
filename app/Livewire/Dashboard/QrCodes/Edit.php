<?php

namespace App\Livewire\Dashboard\QrCodes;

use App\Models\QrCode;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    #[Locked]
    public int $qrCodeId;

    public ?QrCode $qrCode = null;

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

    public ?string $existing_profile_photo = null;

    // PDF fields
    public string $pdf_name = '';

    public string $pdf_description = '';

    public string $pdf_color_l = '#f78e31';

    public string $pdf_color_d = '#527ac9';

    public $pdf_file = null;

    public ?string $existing_pdf_file = null;

    // URL fields
    public string $url_name = '';

    public string $url_url = '';

    public string $url_color_l = '#000000';

    public string $url_color_d = '#ffffff';

    protected function rules(): array
    {
        $rules = [
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
                'pdf_file' => 'nullable|file|mimes:pdf|max:8048',
            ]);
        }

        if ($this->type === 'url') {
            $rules = array_merge($rules, [
                'url_name' => 'required|string|max:255',
                'url_url' => 'required|url|max:2048',
                'url_color_l' => 'required|string',
                'url_color_d' => 'required|string',
            ]);
        }

        return $rules;
    }

    public function mount(QrCode $qrCode): void
    {
        $this->qrCodeId = $qrCode->id;
        $this->qrCode = $qrCode->load(['content', 'pdf', 'url']);

        // Check permission
        $user = Auth::user();
        if ($user->isUser() && $this->qrCode->user_id !== $user->id) {
            abort(403, 'You do not have permission to edit this QR code.');
        }

        // Populate form fields
        $this->type = $this->qrCode->type;
        $this->is_dynamic = $this->qrCode->is_dynamic;

        if ($this->type === 'vcard' && $this->qrCode->content) {
            $content = $this->qrCode->content;
            $this->content_name = $content->name ?? '';
            $this->content_title = $content->title ?? '';
            $this->content_phone = $content->phone ?? '';
            $this->content_email = $content->email ?? '';
            $this->content_company = $content->company ?? '';
            $this->content_linkedin = $content->linkedin ?? '';
            $this->content_x = $content->x ?? '';
            $this->content_snap = $content->snap ?? '';
            $this->content_facebook = $content->facebook ?? '';
            $this->content_instagram = $content->instagram ?? '';
            $this->content_youtube = $content->youtube ?? '';
            $this->content_color_l = $content->color_l ?? '#232421';
            $this->content_color_d = $content->color_d ?? '#f78e31';
            $this->existing_profile_photo = $content->profile_photo_url;
        }

        if ($this->type === 'pdf' && $this->qrCode->pdf) {
            $pdf = $this->qrCode->pdf;
            $this->pdf_name = $pdf->name ?? '';
            $this->pdf_description = $pdf->description ?? '';
            $this->pdf_color_l = $pdf->color_l ?? '#f78e31';
            $this->pdf_color_d = $pdf->color_d ?? '#527ac9';
            $this->existing_pdf_file = $pdf->file;
        }

        if ($this->type === 'url' && $this->qrCode->url) {
            $url = $this->qrCode->url;
            $this->url_name = $url->name ?? '';
            $this->url_url = $url->url ?? '';
            $this->url_color_l = $url->color_l ?? '#000000';
            $this->url_color_d = $url->color_d ?? '#ffffff';
        }
    }

    public function save(): void
    {
        $this->validate();

        $user = Auth::user();

        // Double-check permission
        if ($user->isUser() && $this->qrCode->user_id !== $user->id) {
            session()->flash('error', 'You do not have permission to edit this QR code.');

            return;
        }

        // Update the QR code
        $this->qrCode->update([
            'is_dynamic' => $this->is_dynamic,
        ]);

        if ($this->type === 'vcard') {
            // Handle profile photo upload
            $profilePhotoPath = $this->qrCode->content?->profile_photo_path;
            if ($this->content_profile_photo) {
                $profilePhotoPath = $this->content_profile_photo->store('profile-photos', 'public');
            }

            // Update or create content
            $this->qrCode->content()->updateOrCreate(
                ['qr_code_id' => $this->qrCode->id],
                [
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
                ]
            );
        }

        if ($this->type === 'pdf') {
            // Handle PDF file upload
            $pdfPath = $this->qrCode->pdf?->file;
            if ($this->pdf_file) {
                $pdfPath = $this->pdf_file->store('files', 'public');
            }

            // Update or create PDF record
            $this->qrCode->pdf()->updateOrCreate(
                ['qr_code_id' => $this->qrCode->id],
                [
                    'name' => $this->pdf_name,
                    'description' => $this->pdf_description,
                    'color_l' => $this->pdf_color_l,
                    'color_d' => $this->pdf_color_d,
                    'file' => $pdfPath,
                ]
            );
        }

        if ($this->type === 'url') {
            // Update or create URL record
            $this->qrCode->url()->updateOrCreate(
                ['qr_code_id' => $this->qrCode->id],
                [
                    'name' => $this->url_name,
                    'url' => $this->url_url,
                    'color_l' => $this->url_color_l,
                    'color_d' => $this->url_color_d,
                ]
            );
        }

        session()->flash('success', 'QR Code updated successfully!');
        $this->redirect(route('dashboard.qrcodes.view', $this->qrCode->id));
    }

    public function render()
    {
        return view('livewire.dashboard.qr-codes.edit')
            ->layout('layouts.dashboard', ['title' => 'Edit QR Code']);
    }
}
