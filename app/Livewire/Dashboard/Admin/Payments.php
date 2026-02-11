<?php

namespace App\Livewire\Dashboard\Admin;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Payments extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function mount(): void
    {
        $user = Auth::user();
        if (! $user || ! ($user->isAdmin() || $user->isSuperAdmin())) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Payment::with(['subscription.user', 'subscription.plan']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('payment_id', 'like', "%{$this->search}%")
                    ->orWhereHas('subscription.user', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%")
                            ->orWhere('email', 'like', "%{$this->search}%");
                    });
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $payments = $query->orderByDesc('created_at')->paginate(15);
        $statuses = Payment::distinct('status')->pluck('status')->filter()->toArray();

        return view('livewire.dashboard.admin.payments', [
            'payments' => $payments,
            'statuses' => $statuses,
        ])->layout('layouts.dashboard', ['title' => __('dashboard.payment_history')]);
    }
}
