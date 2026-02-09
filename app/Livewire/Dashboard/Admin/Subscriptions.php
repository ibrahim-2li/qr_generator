<?php

namespace App\Livewire\Dashboard\Admin;

use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Subscriptions extends Component
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

    public function updateStatus(int $id, string $status): void
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update(['status' => $status]);
        session()->flash('success', 'Subscription status updated successfully.');
    }

    public function deleteSubscription(int $id): void
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();
        session()->flash('success', 'Subscription deleted successfully.');
    }

    public function render()
    {
        $query = Subscription::with(['user', 'plan']);

        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $subscriptions = $query->orderByDesc('created_at')->paginate(15);

        return view('livewire.dashboard.admin.subscriptions', [
            'subscriptions' => $subscriptions,
            'statuses' => Subscription::STATUS,
        ])->layout('layouts.dashboard', ['title' => 'Manage Subscriptions']);
    }
}
