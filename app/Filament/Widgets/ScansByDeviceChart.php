<?php

namespace App\Filament\Widgets;

use App\Models\QrCode;
use App\Models\Scan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScansByDeviceChart extends ChartWidget
{
    public array $filters = [];

    protected ?string $heading = 'Scans by Device Type';

    protected static ?int $sort = 3;

    protected ?string $maxHeight = '90px';

    protected function getData(): array
    {
        $user = Auth::user();
        $qrCodeId = $this->filters['qr_code_id'] ?? null;

        $query = Scan::select('device', DB::raw('COUNT(*) as count'))
            ->whereNotNull('device');

        if ($qrCodeId) {
            $query->where('qr_code_id', $qrCodeId);
        } elseif ($user->isUser()) {
            $userQrCodeIds = QrCode::where('user_id', $user->id)->pluck('id');
            $query->whereIn('qr_code_id', $userQrCodeIds);
        }

        $data = $query->groupBy('device')
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
                    ],
                ],
            ],
            'labels' => $data->pluck('device'),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
