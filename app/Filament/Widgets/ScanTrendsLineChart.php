<?php

namespace App\Filament\Widgets;

use App\Models\Scan;
use App\Models\QrCode;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ScanTrendsLineChart extends ChartWidget
{
    protected ?string $heading = 'Scan Trends Line Chart';

    protected static ?int $sort = 7;

    protected function getData(): array
    {
        $user = Auth::user();
        $query = Scan::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as scans')
        )
            ->where('created_at', '>=', now()->subDays(30));

        if ($user->isUser()) {
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
        return 'line';
    }
}
