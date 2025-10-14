<?php

namespace App\Filament\Resources\QrCodes;

use App\Filament\Resources\QrCodes\Pages\CreateQrCode;
use App\Filament\Resources\QrCodes\Pages\EditQrCode;
use App\Filament\Resources\QrCodes\Pages\ListQrCodes;
use App\Filament\Resources\QrCodes\Pages\ViewQrCode;
use App\Filament\Resources\QrCodes\Schemas\QrCodeForm;
use App\Filament\Resources\QrCodes\Tables\QrCodesTable;
use App\Models\QrCode as QrCodeModel;
use BackedEnum;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Filament\Forms\Components\ColorPicker;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class QrCodeResource extends Resource
{
    protected static ?string $model = QrCodeModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::QrCode;

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'QrCode';

    public static function form(Schema $schema): Schema
    {
        return QrCodeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QrCodesTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Auth::user();

        // If user is admin, show all QR codes
        if ($user && $user->isAdmin()) {
            return $query;
        }

        if($user && $user->isSuperAdmin()){
            return $query;
        }
        // If user is regular user, show only their QR codes
        if ($user && $user->isUser()) {
            return $query->where('user_id', $user->id);
        }

        // If no user or unknown role, show nothing
        return $query->whereRaw('1 = 0');
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

                                ImageEntry::make('qr_code')
                                    ->label('QR Code')
                                    ->getStateUsing(function ($record) {
                                        if (! $record->slug) {
                                            return null;
                                        }

                                        $options = new QROptions([
                                            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                                            'eccLevel' => QRCode::ECC_L,
                                            'scale' => 5,
                                            'imageBase64' => true,
                                        ]);

                                        $qrcode = new QRCode($options);
                                        $url = url('/q/'.$record->slug);

                                        return $qrcode->render($url);
                                    })
                                    ->height(200)
                                    ->width(200)
                                    ->square(),

                                TextEntry::make('slug')
                                    ->label('Slug')
                                    ->copyable()
                                    ->placeholder('No slug generated'),

                                TextEntry::make('qr_url')
                                    ->label('QR Code URL')
                                    ->getStateUsing(fn ($record) => $record->slug ? url('/q/'.$record->slug) : 'No URL available')
                                    ->copyable()
                                    ->url(fn ($record) => $record->slug ? url('/q/'.$record->slug) : null),

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
                                ColorPicker::make('content.color_l')
                                    ->label('Color L'),

                                ColorPicker::make('content.color_d')
                                    ->label('Color D'),

                                ImageEntry::make('profile_photo')
                                    ->label('Profile Photo')
                                    ->getStateUsing(function ($record) {
                                        if (! $record->content) {
                                            return null;
                                        }

                                        // Use the accessor method
                                        return $record->content->profile_photo_url;
                                    })
                                    ->height(150)
                                    ->width(150)
                                    ->circular(),

                                TextEntry::make('content.name')
                                    ->label('Name')
                                    ->size('lg')
                                    ->weight('bold'),

                                    TextEntry::make('content.title')
                                    ->label('Title')
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

                                     TextEntry::make('content.snap')
                                    ->label('Snapchat')
                                    ->url(fn ($record) => $record->content?->snap)
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
