<?php

namespace App\Filament\Widgets;

use App\Models\QrCode;
use App\Models\Scan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class QrCodeStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $totalQrCodes = QrCode::count();
            $totalScans = Scan::count();
            $uniqueScans = Scan::distinct('ip')->count();
        } else {
            $userQrCodeIds = QrCode::where('user_id', $user->id)->pluck('id');
            $totalQrCodes = $userQrCodeIds->count();
            $totalScans = Scan::whereIn('qr_code_id', $userQrCodeIds)->count();
            $uniqueScans = Scan::whereIn('qr_code_id', $userQrCodeIds)->distinct('ip')->count();
        }

        return [
            Stat::make('Total QR Codes', $totalQrCodes)
                ->description('All QR codes created')
                ->descriptionIcon('heroicon-m-qr-code')
                ->color('primary'),

            Stat::make('Total Scans', $totalScans)
                ->description('All scan events recorded')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success'),

            Stat::make('Unique Scans', $uniqueScans)
                ->description('Unique IP addresses')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}
