<?php

namespace App\Filament\Resources\QrCodes\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
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
                        TextInput::make('type')
                            ->required(),

                        Toggle::make('is_dynamic')
                            ->required(),
                    ]),

                Section::make('QR Content')
                    ->relationship('content')
                    ->schema([
                        ColorPicker::make('color_l')
                            ->default('#232421'),

                        ColorPicker::make('color_d')
                            ->default('#f78e31'),

                        FileUpload::make('profile_photo_path')
                            ->image()
                            ->disk('public')
                            ->directory('profile-photos')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/*'])
                            ->maxSize(2048),

                        TextInput::make('name')
                            ->required(),

                        TextInput::make('phone')
                            ->tel(),

                        TextInput::make('email')
                            ->email(),

                        TextInput::make('company'),

                        TextInput::make('linkedin')
                            ->url(),

                        TextInput::make('x')
                            ->url(),

                        TextInput::make('snap')
                            ->string(),

                        TextInput::make('facebook')
                            ->url(),

                        TextInput::make('instagram')
                            ->url(),

                        TextInput::make('youtube')
                            ->url(),
                    ]),
            ]);
    }
}
