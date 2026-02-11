<?php

namespace App\Livewire\Dashboard\Admin;

use App\Models\Partner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Partners extends Component
{
    use WithFileUploads;
    use WithPagination;

    public string $search = '';

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    // Form fields
    public bool $showModal = false;

    public ?int $editingId = null;

    public string $name = '';

    public string $url = '';

    public $image;

    public ?string $existingImage = null;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'image' => $this->editingId ? 'nullable|image|max:2048' : 'required|image|max:2048',
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
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $partner = Partner::findOrFail($id);
        $this->editingId = $partner->id;
        $this->name = $partner->name;
        $this->url = $partner->url;
        $this->existingImage = $partner->image;
        $this->image = null;
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
        $this->name = '';
        $this->url = '';
        $this->image = null;
        $this->existingImage = null;
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'url' => $this->url,
        ];

        if ($this->image) {
            // Delete old image if editing
            if ($this->editingId && $this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }
            $data['image'] = $this->image->store('partners', 'public');
        }

        if ($this->editingId) {
            $partner = Partner::findOrFail($this->editingId);
            $partner->update($data);
            session()->flash('success', 'Partner updated successfully.');
        } else {
            Partner::create($data);
            session()->flash('success', 'Partner created successfully.');
        }

        $this->closeModal();
    }

    public function deletePartner(int $id): void
    {
        $partner = Partner::find($id);

        if (! $partner) {
            session()->flash('error', 'Partner not found.');

            return;
        }

        // Delete image file
        if ($partner->image) {
            Storage::disk('public')->delete($partner->image);
        }

        $partner->delete();
        session()->flash('success', 'Partner deleted successfully.');
    }

    public function render()
    {
        $query = Partner::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('url', 'like', "%{$this->search}%");
            });
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        $partners = $query->paginate(15);

        return view('livewire.dashboard.admin.partners', [
            'partners' => $partners,
        ])->layout('layouts.dashboard', ['title' => __('dashboard.manage_partners')]);
    }
}
