<?php

namespace App\Livewire\Dashboard\QrCodes;

use App\Models\QrCode;
use chillerlan\QRCode\QRCode as QRCodeGenerator;
use chillerlan\QRCode\QROptions;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $typeFilter = '';

    public string $statusFilter = '';

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingTypeFilter(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function deleteQrCode(int $id): void
    {
        $user = Auth::user();
        $qrCode = QrCode::find($id);

        if (! $qrCode) {
            session()->flash('error', 'QR Code not found.');

            return;
        }

        // Check permission
        if ($user->isUser() && $qrCode->user_id !== $user->id) {
            session()->flash('error', 'You do not have permission to delete this QR code.');

            return;
        }

        $qrCode->delete();
        session()->flash('success', 'QR Code deleted successfully.');
    }

    /**
     * Generate a QR code image for a given QR code.
     */
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

    /**
     * Determine the status of a QR code based on user subscription/trial.
     */
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

    public function render()
    {
        $user = Auth::user();

        $query = QrCode::with('user', 'content', 'pdf', 'url');

        // Filter by user if not admin
        if ($user->isUser()) {
            $query->where('user_id', $user->id);
        }

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('slug', 'like', "%{$this->search}%")
                    ->orWhere('type', 'like', "%{$this->search}%")
                    ->orWhereHas('content', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%");
                    })
                    ->orWhereHas('pdf', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%");
                    })
                    ->orWhereHas('url', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%");
                    });
            });
        }

        // Type filter
        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }

        // Status filter
        if ($this->statusFilter === 'active') {
            $query->active();
        } elseif ($this->statusFilter === 'inactive') {
            $query->whereDoesntHave('user', function ($q) {
                $q->where(function ($subQuery) {
                    $subQuery->where('role', \App\Models\User::ROLE_ADMIN)
                        ->orWhere('role', \App\Models\User::ROLE_SUPER_ADMIN)
                        ->orWhereHas('subscriptions', function ($subscriptionQuery) {
                            $subscriptionQuery->where('status', 'active')
                                ->where('ends_at', '>', now());
                        })
                        ->orWhere(function ($trialQuery) {
                            $trialQuery->whereNotNull('trial_ends_at')
                                ->where('trial_ends_at', '>', now());
                        });
                });
            });
        }

        // Sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        $qrCodes = $query->paginate(10);

        return view('livewire.dashboard.qr-codes.index', [
            'qrCodes' => $qrCodes,
            'types' => QrCode::distinct('type')->pluck('type')->toArray(),
        ])->layout('layouts.dashboard', ['title' => __('dashboard.my_qr_codes')]);
    }
}
