<?php

namespace App\Livewire\Dashboard\Admin;

use App\Models\Faq;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Faqs extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = '';

    public string $sortField = 'sort_order';

    public string $sortDirection = 'asc';

    // Form fields
    public bool $showModal = false;

    public ?int $editingId = null;

    public string $question = '';

    public string $answer = '';

    public int $sort_order = 0;

    public bool $is_active = true;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    protected function rules(): array
    {
        return [
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ];
    }

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

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->sort_order = Faq::max('sort_order') + 1;
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $faq = Faq::findOrFail($id);
        $this->editingId = $faq->id;
        $this->question = $faq->question;
        $this->answer = $faq->answer;
        $this->sort_order = $faq->sort_order;
        $this->is_active = $faq->is_active;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->editingId = null;
        $this->question = '';
        $this->answer = '';
        $this->sort_order = 0;
        $this->is_active = true;
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'question' => $this->question,
            'answer' => $this->answer,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];

        if ($this->editingId) {
            $faq = Faq::findOrFail($this->editingId);
            $faq->update($data);
            session()->flash('success', 'FAQ updated successfully.');
        } else {
            Faq::create($data);
            session()->flash('success', 'FAQ created successfully.');
        }

        $this->closeModal();
    }

    public function toggleActive(int $id): void
    {
        $faq = Faq::find($id);

        if (! $faq) {
            session()->flash('error', 'FAQ not found.');

            return;
        }

        $faq->update(['is_active' => ! $faq->is_active]);
        session()->flash('success', $faq->is_active ? 'FAQ activated.' : 'FAQ deactivated.');
    }

    public function deleteFaq(int $id): void
    {
        $faq = Faq::find($id);

        if (! $faq) {
            session()->flash('error', 'FAQ not found.');

            return;
        }

        $faq->delete();
        session()->flash('success', 'FAQ deleted successfully.');
    }

    public function render()
    {
        $query = Faq::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('question', 'like', "%{$this->search}%")
                    ->orWhere('answer', 'like', "%{$this->search}%");
            });
        }

        if ($this->statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        $faqs = $query->paginate(15);

        return view('livewire.dashboard.admin.faqs', [
            'faqs' => $faqs,
        ])->layout('layouts.dashboard', ['title' => 'Manage FAQs']);
    }
}
