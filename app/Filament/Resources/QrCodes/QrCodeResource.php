<?php

namespace App\Filament\Resources\QrCodes;

use App\Filament\Resources\QrCodes\Pages\CreateQrCode;
use App\Filament\Resources\QrCodes\Pages\EditQrCode;
use App\Filament\Resources\QrCodes\Pages\ListQrCodes;
use App\Filament\Resources\QrCodes\Pages\ViewQrCode;
use App\Filament\Resources\QrCodes\Schemas\QrCodeForm;
use App\Filament\Resources\QrCodes\Tables\QrCodesTable;
use App\Models\QrCode;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;



class QrCodeResource extends Resource
{
    protected static ?string $model = QrCode::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'QrCode';

    public static function form(Schema $schema): Schema
    {
        return QrCodeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QrCodesTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('QR Code Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('id')
                                    ->label('ID'),

                                TextEntry::make('type')
                                    ->label('Type'),

                                TextEntry::make('slug')
                                    ->label('Slug')
                                    ->copyable(),

                                TextEntry::make('is_dynamic')
                                    ->label('Is Dynamic')
                                    ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No'),

                                TextEntry::make('scan_count')
                                    ->label('Scan Count')
                                    ->numeric(),

                                TextEntry::make('user.name')
                                    ->label('Created By'),

                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime(),

                                TextEntry::make('updated_at')
                                    ->label('Updated At')
                                    ->dateTime(),
                            ]),
                    ]),

                Section::make('QR Content')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                ImageEntry::make('content.profile_photo_url')
                                    ->label('Profile Photo')
                                    ->height(150)
                                    ->width(150)
                                    ->circular(),

                                TextEntry::make('content.name')
                                    ->label('Name')
                                    ->size('lg')
                                    ->weight('bold'),

                                TextEntry::make('content.company')
                                    ->label('Company'),

                                TextEntry::make('content.email')
                                    ->label('Email')
                                    ->copyable()
                                    ->icon(Heroicon::Envelope),

                                TextEntry::make('content.phone')
                                    ->label('Phone')
                                    ->copyable()
                                    ->icon(Heroicon::Phone),

                                TextEntry::make('content.linkedin')
                                    ->label('LinkedIn')
                                    ->url(fn ($record) => $record->content?->linkedin)
                                    ->icon(Heroicon::Link),

                                TextEntry::make('content.x')
                                    ->label('X (Twitter)')
                                    ->url(fn ($record) => $record->content?->x)
                                    ->icon(Heroicon::Link),

                                TextEntry::make('content.facebook')
                                    ->label('Facebook')
                                    ->url(fn ($record) => $record->content?->facebook)
                                    ->icon(Heroicon::Link),

                                TextEntry::make('content.instagram')
                                    ->label('Instagram')
                                    ->url(fn ($record) => $record->content?->instagram)
                                    ->icon(Heroicon::Link),

                                TextEntry::make('content.youtube')
                                    ->label('YouTube')
                                    ->url(fn ($record) => $record->content?->youtube)
                                    ->icon(Heroicon::Link),
                            ]),
                    ])
                    ->visible(fn ($record) => $record->content !== null),
            ]);
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
            'index' => ListQrCodes::route('/'),
            'create' => CreateQrCode::route('/create'),
            'view' => ViewQrCode::route('/{record}'),
            'edit' => EditQrCode::route('/{record}/edit'),
        ];
    }

}
