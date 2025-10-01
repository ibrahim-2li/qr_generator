<?php

namespace App\Filament\Resources\QrContents;

use App\Filament\Resources\QrContents\Pages\CreateQrContent;
use App\Filament\Resources\QrContents\Pages\EditQrContent;
use App\Filament\Resources\QrContents\Pages\ListQrContents;
use App\Filament\Resources\QrContents\Schemas\QrContentForm;
use App\Filament\Resources\QrContents\Tables\QrContentsTable;
use App\Models\QrContent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QrContentResource extends Resource
{
    protected static ?string $model = QrContent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'QrContent';

    public static function form(Schema $schema): Schema
    {
        return QrContentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QrContentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQrContents::route('/'),
            'create' => CreateQrContent::route('/create'),
            'edit' => EditQrContent::route('/{record}/edit'),
        ];
    }
}
