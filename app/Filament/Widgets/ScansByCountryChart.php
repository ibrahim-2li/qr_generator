<?php

namespace App\Filament\Widgets;

use App\Models\QrCode;
use App\Models\Scan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScansByCountryChart extends ChartWidget
{
    public array $filters = [];

    protected ?string $heading = 'Scans by Country';

    protected static ?int $sort = 1;

    protected ?string $maxHeight = '90px';

    protected function getData(): array
    {
        $user = Auth::user();
        $qrCodeId = $this->filters['qr_code_id'] ?? null;

        $query = Scan::select('country', DB::raw('COUNT(*) as count'))
            ->whereNotNull('country');

        if ($qrCodeId) {
            $query->where('qr_code_id', $qrCodeId);
        } elseif ($user->isUser()) {
            $userQrCodeIds = QrCode::where('user_id', $user->id)->pluck('id');
            $query->whereIn('qr_code_id', $userQrCodeIds);
        }

        $data = $query->groupBy('country')
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
            'labels' => $data->pluck('country'),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
