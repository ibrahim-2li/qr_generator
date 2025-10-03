<?php

namespace App\Filament\Widgets;

use App\Models\QrCode;
use App\Models\Scan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScansByRegionChart extends ChartWidget
{
    protected ?string $heading = 'Scans by Region/City';

    protected static ?int $sort = 4;

    protected ?string $maxHeight = '90px';

    protected function getData(): array
    {
        $user = Auth::user();
        $query = Scan::select('region', DB::raw('COUNT(*) as count'))
            ->whereNotNull('region');

        if (! $user->isAdmin()) {
            $userQrCodeIds = QrCode::where('user_id', $user->id)->pluck('id');
            $query->whereIn('qr_code_id', $userQrCodeIds);
        }

        $data = $query->groupBy('region')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Scans',
                    'data' => $data->pluck('count'),
                    'backgroundColor' => [
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)',
                        'rgb(139, 92, 246)',
                        'rgb(236, 72, 153)',
                        'rgb(6, 182, 212)',
                        'rgb(34, 197, 94)',
                        'rgb(251, 146, 60)',
                        'rgb(168, 85, 247)',
                    ],
                ],
            ],
            'labels' => $data->pluck('region'),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
