<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Tables\Columns\Layout\Panel as Enter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_USER = 'USER';
    const ROLE_ADMIN = 'ADMIN';

    const ROLES = [
        self::ROLE_USER => 'User',
        self::ROLE_ADMIN => 'Admin',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar_url',
        'trial_ends_at',
        'trial_used',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'trial_ends_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

       public function canAccessPanel(Panel $panel): bool
        {

     if ($panel->getId() === 'ADMIN' || 'USER') {
            return str_ends_with($this->email, '@yourdomain.com') ;
        }

        return true;
    }

    public function canAccess(Enter $panel): bool
    {
        return $this->isAdmin() || $this->isUser();
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function qrCodes()
    {
        return $this->hasMany(\App\Models\QrCode::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        $avatarColumn = config('filament-edit-profile.avatar_column', 'avatar_url');

        return $this->$avatarColumn ? Storage::url($this->$avatarColumn) : null;
    }

    /**
     * Check if user has an active subscription
     */
    public function hasActiveSubscription(): bool
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->exists();
    }

    /**
     * Check if user is on trial period
     */
    public function isOnTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Check if user can create QR codes
     */
    public function canCreateQrCodes(): bool
    {
        // Admin can always create QR codes
        if ($this->isAdmin()) {
            return true;
        }

        // User can create if they have active subscription or are on trial
        return $this->hasActiveSubscription() || $this->isOnTrial();
    }

    /**
     * Check if user's QR codes should be active
     */
    public function qrCodesShouldBeActive(): bool
    {
        // Admin's QR codes are always active
        if ($this->isAdmin()) {
            return true;
        }

        // QR codes are active if user has active subscription or is on trial
        return $this->hasActiveSubscription() || $this->isOnTrial();
    }

    /**
     * Get trial status information
     */
    public function getTrialStatus(): array
    {
        if (!$this->trial_ends_at) {
            return [
                'is_trial' => false,
                'days_remaining' => 0,
                'expired' => false,
            ];
        }

        $isExpired = $this->trial_ends_at->isPast();
        $daysRemaining = $isExpired ? 0 : now()->diffInDays($this->trial_ends_at, false);

        return [
            'is_trial' => !$isExpired,
            'days_remaining' => max(0, $daysRemaining),
            'expired' => $isExpired,
            'ends_at' => $this->trial_ends_at,
        ];
    }

    /**
     * Start trial period for new users
     */
    public function startTrial(): void
    {
        if (!$this->trial_used) {
            $this->update([
                'trial_ends_at' => now()->addDays(7),
                'trial_used' => true,
            ]);
        }
    }
}
