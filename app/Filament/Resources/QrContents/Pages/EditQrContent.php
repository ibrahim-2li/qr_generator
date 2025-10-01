<?php

namespace App\Filament\Resources\QrContents\Pages;

use App\Filament\Resources\QrContents\QrContentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQrContent extends EditRecord
{
    protected static string $resource = QrContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
