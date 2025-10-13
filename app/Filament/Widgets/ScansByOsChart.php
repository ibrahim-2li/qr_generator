<?php

namespace App\Filament\Widgets;

use App\Models\QrCode;
use App\Models\Scan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScansByOsChart extends ChartWidget
{
    protected ?string $heading = 'Scans by Operating System';

    protected static ?int $sort = 4;

    protected ?string $maxHeight = '90px';

    protected function getData(): array
    {
        $user = Auth::user();
        $query = Scan::select('os', DB::raw('COUNT(*) as count'))
            ->whereNotNull('os');

        if ($user->isUser()) {
            $userQrCodeIds = QrCode::where('user_id', $user->id)->pluck('id');
            $query->whereIn('qr_code_id', $userQrCodeIds);
        }

        $data = $query->groupBy('os')
            ->orderByDesc('count')
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
                    ],
                ],
            ],
            'labels' => $data->pluck('os'),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
