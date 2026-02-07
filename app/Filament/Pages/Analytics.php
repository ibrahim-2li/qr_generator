<?php

namespace App\Filament\Pages;

use App\Models\QrCode;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class Analytics extends Page
{
    use HasFiltersAction;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartBar;

    protected static ?string $navigationLabel = 'Analytics';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.analytics';

    protected function getHeaderActions(): array
    {
        return [
            FilterAction::make()
                ->schema([
                    Select::make('qr_code_id')
                        ->label('QR Code')
                        ->placeholder('All QR Codes')
                        ->options(function () {
                            $user = Auth::user();
                            $query = QrCode::query();

                            if ($user->isUser()) {
                                $query->where('user_id', $user->id);
                            }

                            return $query->get()->mapWithKeys(function ($qrCode) {
                                $name = $qrCode->content?->name ?? $qrCode->pdf?->name ?? 'Unknown';

                                return [$qrCode->id => ucfirst($qrCode->type).' - '.$name];
                            });
                        })
                        ->searchable()
                        ->preload(),
                ]),
        ];
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\QrCodeStatsWidget::class,
            \App\Filament\Widgets\ScansByCountryChart::class,
            \App\Filament\Widgets\ScansByRegionChart::class,
            \App\Filament\Widgets\ScansByDeviceChart::class,
            \App\Filament\Widgets\ScansByOsChart::class,
            \App\Filament\Widgets\ScanTrendsChart::class,
            \App\Filament\Widgets\ScanTrendsLineChart::class,
        ];
    }
}
