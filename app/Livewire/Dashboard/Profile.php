<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $email = '';

    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    public $avatar = null;

    public ?string $existing_avatar = null;

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->existing_avatar = $user->getAvatarUrl();
    }

    public function updateProfile(): void
    {
        $user = Auth::user();

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'avatar' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $data['avatar_url'] = $path;
            $this->existing_avatar = asset('storage/'.$path);
        }

        $user->update($data);
        $this->avatar = null;

        session()->flash('profile_success', 'Profile updated successfully.');
    }

    public function updatePassword(): void
    {
        $user = Auth::user();

        $this->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Verify current password
        if (! Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'The current password is incorrect.');

            return;
        }

        $user->update([
            'password' => Hash::make($this->password),
        ]);

        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';

        session()->flash('password_success', 'Password updated successfully.');
    }

    public function render()
    {
        return view('livewire.dashboard.profile')
            ->layout('layouts.dashboard', ['title' => __('dashboard.my_profile')]);
    }
}
