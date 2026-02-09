<?php

namespace App\Livewire\Dashboard\Admin;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Messages extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = '';

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    // View modal
    public bool $showViewModal = false;

    public ?Contact $viewingMessage = null;

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

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function viewMessage(int $id): void
    {
        $this->viewingMessage = Contact::findOrFail($id);

        // Mark as read
        if (! $this->viewingMessage->is_read) {
            $this->viewingMessage->update(['is_read' => true]);
        }

        $this->showViewModal = true;
    }

    public function closeViewModal(): void
    {
        $this->showViewModal = false;
        $this->viewingMessage = null;
    }

    public function toggleRead(int $id): void
    {
        $message = Contact::find($id);

        if (! $message) {
            session()->flash('error', 'Message not found.');

            return;
        }

        $message->update(['is_read' => ! $message->is_read]);
        session()->flash('success', $message->is_read ? 'Marked as read.' : 'Marked as unread.');
    }

    public function deleteMessage(int $id): void
    {
        $message = Contact::find($id);

        if (! $message) {
            session()->flash('error', 'Message not found.');

            return;
        }

        $message->delete();
        session()->flash('success', 'Message deleted successfully.');
    }

    public function render()
    {
        $query = Contact::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('subject', 'like', "%{$this->search}%");
            });
        }

        if ($this->statusFilter === 'read') {
            $query->where('is_read', true);
        } elseif ($this->statusFilter === 'unread') {
            $query->where('is_read', false);
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        $messages = $query->paginate(15);
        $unreadCount = Contact::where('is_read', false)->count();

        return view('livewire.dashboard.admin.messages', [
            'messages' => $messages,
            'unreadCount' => $unreadCount,
        ])->layout('layouts.dashboard', ['title' => 'Messages']);
    }
}
