<?php

namespace App\Filament\Widgets;

use App\Models\QrCode;
use App\Models\Scan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScanTrendsChart extends ChartWidget
{
    public array $filters = [];

    protected ?string $heading = 'Scan Trends (Last 30 Days)';

    protected static ?int $sort = 6;

    protected function getData(): array
    {
        $user = Auth::user();
        $qrCodeId = $this->filters['qr_code_id'] ?? null;

        $query = Scan::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as scans')
        )
            ->where('created_at', '>=', now()->subDays(30));

        if ($qrCodeId) {
            $query->where('qr_code_id', $qrCodeId);
        } elseif ($user->isUser()) {
            $userQrCodeIds = QrCode::where('user_id', $user->id)->pluck('id');
            $query->whereIn('qr_code_id', $userQrCodeIds);
        }

        $data = $query->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Scans',
                    'data' => $data->pluck('scans'),
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $data->pluck('date'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
