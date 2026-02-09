<?php

namespace App\Livewire\Dashboard\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public string $search = '';

    public string $roleFilter = '';

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    // View Modal
    public bool $showViewModal = false;

    public ?User $viewingUser = null;

    // Edit Modal
    public bool $showEditModal = false;

    public ?int $editingId = null;

    public string $name = '';

    public string $email = '';

    public string $role = '';

    public string $password = '';

    public string $password_confirmation = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
    ];

    protected function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$this->editingId,
            'role' => 'required|in:USER,ADMIN,SUPER_ADMIN',
        ];

        if ($this->password) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
    }

    public function mount(): void
    {
        // Check if user has admin access
        $user = Auth::user();
        if (! $user || ! ($user->isAdmin() || $user->isSuperAdmin())) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingRoleFilter(): void
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

    public function viewUser(int $id): void
    {
        $this->viewingUser = User::withCount(['qrCodes', 'subscriptions'])->findOrFail($id);
        $this->showViewModal = true;
    }

    public function closeViewModal(): void
    {
        $this->showViewModal = false;
        $this->viewingUser = null;
    }

    public function openEditModal(int $id): void
    {
        $user = User::findOrFail($id);
        $authUser = Auth::user();

        // Only super admin can edit other admins
        if ($user->isAdmin() && ! $authUser->isSuperAdmin() && $user->id !== $authUser->id) {
            session()->flash('error', 'Only super admins can edit admin users.');

            return;
        }

        $this->editingId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = '';
        $this->password_confirmation = '';
        $this->showEditModal = true;
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->editingId = null;
        $this->name = '';
        $this->email = '';
        $this->role = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate();

        $user = User::findOrFail($this->editingId);
        $authUser = Auth::user();

        // Only super admin can change roles to admin/super_admin
        if ($this->role !== $user->role) {
            if (in_array($this->role, ['ADMIN', 'SUPER_ADMIN']) && ! $authUser->isSuperAdmin()) {
                session()->flash('error', 'Only super admins can promote users to admin roles.');

                return;
            }
        }

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $user->update($data);
        session()->flash('success', 'User updated successfully.');
        $this->closeEditModal();
    }

    public function deleteUser(int $id): void
    {
        $authUser = Auth::user();
        $user = User::find($id);

        if (! $user) {
            session()->flash('error', 'User not found.');

            return;
        }

        // Cannot delete yourself
        if ($user->id === $authUser->id) {
            session()->flash('error', 'You cannot delete your own account.');

            return;
        }

        // Only super admin can delete admins
        if ($user->isAdmin() && ! $authUser->isSuperAdmin()) {
            session()->flash('error', 'Only super admins can delete admin users.');

            return;
        }

        $user->delete();
        session()->flash('success', 'User deleted successfully.');
    }

    public function render()
    {
        $query = User::withCount(['qrCodes', 'subscriptions']);

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        // Role filter
        if ($this->roleFilter) {
            $query->where('role', $this->roleFilter);
        }

        // Sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        $users = $query->paginate(15);

        return view('livewire.dashboard.admin.users', [
            'users' => $users,
            'roles' => User::ROLES,
        ])->layout('layouts.dashboard', ['title' => 'Manage Users']);
    }
}
