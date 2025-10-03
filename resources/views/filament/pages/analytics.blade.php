<x-filament-panels::page>
    @livewire(\App\Filament\Widgets\QrCodeStatsWidget::class)

    @livewire(\App\Filament\Widgets\ScansByOsChart::class)

    @livewire(\App\Filament\Widgets\ScansByCountryChart::class)
    @livewire(\App\Filament\Widgets\ScansByRegionChart::class)
    @livewire(\App\Filament\Widgets\ScansByDeviceChart::class)


    @livewire(\App\Filament\Widgets\ScanTrendsChart::class)

</x-filament-panels::page>
