<?php

namespace App\Livewire\Dashboard;

use App\Models\QrCode;
use App\Models\Scan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Analytics extends Component
{
    public ?int $selectedQrCodeId = null;

    public array $qrCodeOptions = [];

    public int $totalQrCodes = 0;

    public int $totalScans = 0;

    public int $uniqueScans = 0;

    public array $scansByCountry = [];

    public array $scansByRegion = [];

    public array $scansByCity = [];

    public array $scansByDevice = [];

    public array $scansByOs = [];

    public array $scanTrendsByDay = [];

    public function mount(): void
    {
        $this->loadQrCodeOptions();
        $this->loadStats();
    }

    public function updatedSelectedQrCodeId(): void
    {
        $this->loadStats();
    }

    protected function loadQrCodeOptions(): void
    {
        $user = Auth::user();
        $query = QrCode::query();

        if ($user->isUser()) {
            $query->where('user_id', $user->id);
        }

        $this->qrCodeOptions = $query->get()->mapWithKeys(function ($qrCode) {
            $name = $qrCode->content?->name ?? $qrCode->pdf?->name ?? $qrCode->url?->name ?? 'Unknown';

            return [$qrCode->id => ucfirst($qrCode->type).' - '.$name];
        })->toArray();
    }

    protected function loadStats(): void
    {
        $user = Auth::user();

        // Base query
        if ($this->selectedQrCodeId) {
            $scansQuery = Scan::where('qr_code_id', $this->selectedQrCodeId);
            $this->totalQrCodes = 1;
        } elseif ($user->isAdmin() || $user->isSuperAdmin()) {
            $scansQuery = Scan::query();
            $this->totalQrCodes = QrCode::count();
        } else {
            $userQrCodeIds = QrCode::where('user_id', $user->id)->pluck('id');
            $scansQuery = Scan::whereIn('qr_code_id', $userQrCodeIds);
            $this->totalQrCodes = $userQrCodeIds->count();
        }

        // Total and unique scans
        $this->totalScans = (clone $scansQuery)->count();
        $this->uniqueScans = (clone $scansQuery)->distinct('ip')->count('ip');

        // Scans by country
        $this->scansByCountry = (clone $scansQuery)
            ->select('country', DB::raw('count(*) as count'))
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit(10)
            ->pluck('count', 'country')
            ->toArray();

        // Scans by region
        $this->scansByRegion = (clone $scansQuery)
            ->select('region', DB::raw('count(*) as count'))
            ->groupBy('region')
            ->orderByDesc('count')
            ->limit(10)
            ->pluck('count', 'region')
            ->toArray();

        // Scans by city
        $this->scansByCity = (clone $scansQuery)
            ->select('city', DB::raw('count(*) as count'))
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit(10)
            ->pluck('count', 'city')
            ->toArray();

        // Scans by device
        $this->scansByDevice = (clone $scansQuery)
            ->select('device', DB::raw('count(*) as count'))
            ->groupBy('device')
            ->orderByDesc('count')
            ->pluck('count', 'device')
            ->toArray();

        // Scans by OS
        $this->scansByOs = (clone $scansQuery)
            ->select('os', DB::raw('count(*) as count'))
            ->groupBy('os')
            ->orderByDesc('count')
            ->pluck('count', 'os')
            ->toArray();

        // Scan trends by day (last 30 days)
        $this->scanTrendsByDay = (clone $scansQuery)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard.analytics')
            ->layout('layouts.dashboard', ['title' => __('dashboard.analytics')]);
    }
}
