<?php

namespace App\Livewire\Dashboard\QrCodes;

use App\Models\QrCode;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $typeFilter = '';

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'typeFilter' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingTypeFilter(): void
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

        // Sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        $qrCodes = $query->paginate(10);

        return view('livewire.dashboard.qr-codes.index', [
            'qrCodes' => $qrCodes,
            'types' => QrCode::distinct('type')->pluck('type')->toArray(),
        ])->layout('layouts.dashboard', ['title' => 'My QR Codes']);
    }
}
