<?php

namespace App\Models;

use App\Models\Scan;
use App\Models\User;
use App\Models\QrContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QrCode extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','type','data','is_dynamic','slug','scan_count'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function scans()
    {
        return $this->hasMany(Scan::class);
    }

    public function content()
    {
        return $this->hasOne(QrContent::class);
    }

    /**
     * Scope to get only active QR codes (user has active subscription or is on trial)
     */
    public function scopeActive(Builder $query): void
    {
        $query->whereHas('user', function (Builder $userQuery) {
            $userQuery->where(function (Builder $subQuery) {
                // Admin users
                $subQuery->where('role', User::ROLE_ADMIN)
                    ->orWhere('role', User::ROLE_SUPER_ADMIN)
                    // Users with active subscriptions
                    ->orWhereHas('subscriptions', function (Builder $subscriptionQuery) {
                        $subscriptionQuery->where('status', 'active')
                            ->where('ends_at', '>', now());
                    })
                    // Users on trial
                    ->orWhere(function (Builder $trialQuery) {
                        $trialQuery->whereNotNull('trial_ends_at')
                            ->where('trial_ends_at', '>', now());
                    });
            });
        });
    }
}
