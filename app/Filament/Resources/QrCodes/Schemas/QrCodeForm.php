<?php

namespace App\Filament\Resources\QrCodes\Schemas;

use App\Models\QrCode;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class QrCodeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
        ->components([

            Section::make('QR Code Information')
                ->schema([
                    Select::make('type')
                        ->options(QrCode::TYPE)
                        ->required()
                        ->reactive()
                        ->disabled(fn (string $context) => $context === 'edit'), // 👈 IMPORTANT: enables live change detection

                    Toggle::make('is_dynamic')
                        ->required(),
                ]),

            // ===== PDF SECTION =====
            Section::make('QR Pdf')
                ->relationship('pdf')
                ->visible(fn (callable $get) => $get('type') === 'pdf') // 👈 only show if type = pdf
                ->schema([
                    ColorPicker::make('color_l')
                        ->default('#f78e31'),

                    ColorPicker::make('color_d')
                        ->default('#527ac9'),

                    TextInput::make('name')
                        ->required(),

                    TextInput::make('description')
                        ->required(),

                    FileUpload::make('file')
                        ->acceptedFileTypes(['application/pdf'])
                        ->disk('public')
                        ->directory('files')
                        ->visibility('public')
                        ->maxSize(8048)
                        ->required(),
                ]),

            // ===== vCARD SECTION =====
            Section::make('QR Content (vCard)')
                ->relationship('content')
                ->visible(fn (callable $get) => $get('type') === 'vcard') // 👈 only show if type = vcard
                ->schema([
                    ColorPicker::make('color_l')
                        ->default('#232421'),

                    ColorPicker::make('color_d')
                        ->default('#f78e31'),

                    FileUpload::make('profile_photo_path')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                                    '16:9',
                                    '4:3',
                                    '1:1',
                                ])
                        ->image()
                        ->disk('public')
                        ->directory('profile-photos')
                        ->visibility('public')
                        ->maxSize(2048),

                    TextInput::make('name')->required(),
                    TextInput::make('title'),
                    TextInput::make('phone')->tel()
                    ->required(),
                    TextInput::make('email')->email()
                    ->required(),
                    TextInput::make('company'),
                    TextInput::make('linkedin')->url(),
                    TextInput::make('x')->url(),
                    TextInput::make('snap')->string(),
                    TextInput::make('facebook')->url(),
                    TextInput::make('instagram')->url(),
                    TextInput::make('youtube')->url(),
                ]),
        ]);
    }
}
