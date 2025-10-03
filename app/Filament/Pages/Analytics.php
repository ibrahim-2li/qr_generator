<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Analytics extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartBar;

    protected static ?string $navigationLabel = 'Analytics';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.analytics';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\QrCodeStatsWidget::class,
            \App\Filament\Widgets\ScansByCountryChart::class,
            \App\Filament\Widgets\ScansByRegionChart::class,
            \App\Filament\Widgets\ScansByDeviceChart::class,
            \App\Filament\Widgets\ScansByOsChart::class,
            \App\Filament\Widgets\ScanTrendsChart::class,
        ];
    }
}
