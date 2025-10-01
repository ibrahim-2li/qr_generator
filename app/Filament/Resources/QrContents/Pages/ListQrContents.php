<?php

namespace App\Filament\Resources\QrContents\Pages;

use App\Filament\Resources\QrContents\QrContentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQrContents extends ListRecords
{
    protected static string $resource = QrContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
